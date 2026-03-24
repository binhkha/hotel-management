<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Room;

class BookingHistoryController extends Controller
{
    public function index(Request $request)
    {
        // Kiểm tra đăng nhập
        if (!session('user_logged_in')) {
            return redirect('/')->with('error', 'Vui lòng đăng nhập để xem lịch sử đặt phòng!');
        }

        $query = Booking::with('room');
        $isAdmin = session('user_email') === 'admin@hotel.com';

        // Nếu không phải admin, chỉ xem được lịch sử của mình
        if (!$isAdmin) {
            $query->where('customer_email', session('user_email'));
        }

        // Tìm kiếm theo tên khách hàng (chỉ admin mới tìm kiếm được)
        if ($isAdmin && $request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%");
            });
        }

        // Lọc theo trạng thái
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Lọc theo khoảng thời gian
        if ($request->filled('date_from')) {
            $query->where('checkin', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('checkout', '<=', $request->date_to);
        }

        // Sắp xếp theo ngày tạo mới nhất
        $bookings = $query->orderBy('created_at', 'desc')->paginate(10);

        // Thống kê (khác nhau cho admin và user thường)
        if ($isAdmin) {
            $stats = [
                'total' => Booking::count(),
                'pending' => Booking::where('status', 'pending')->count(),
                'confirmed' => Booking::where('status', 'confirmed')->count(),
                'cancelled' => Booking::where('status', 'cancelled')->count(),
            ];
        } else {
            $userEmail = session('user_email');
            $stats = [
                'total' => Booking::where('customer_email', $userEmail)->count(),
                'pending' => Booking::where('customer_email', $userEmail)->where('status', 'pending')->count(),
                'confirmed' => Booking::where('customer_email', $userEmail)->where('status', 'confirmed')->count(),
                'cancelled' => Booking::where('customer_email', $userEmail)->where('status', 'cancelled')->count(),
            ];
        }

        return view('booking.history', compact('bookings', 'stats', 'isAdmin'));
    }

    public function show($id)
    {
        // Kiểm tra đăng nhập
        if (!session('user_logged_in')) {
            return redirect('/')->with('error', 'Vui lòng đăng nhập để xem chi tiết đơn đặt phòng!');
        }

        $booking = Booking::with('room')->findOrFail($id);
        $isAdmin = session('user_email') === 'admin@hotel.com';

        // Nếu không phải admin, chỉ xem được đơn đặt phòng của mình
        if (!$isAdmin && $booking->customer_email !== session('user_email')) {
            return redirect('/')->with('error', 'Bạn không có quyền xem đơn đặt phòng này!');
        }

        return view('booking.detail', compact('booking', 'isAdmin'));
    }

    public function export(Request $request)
    {
        // Chỉ admin mới xuất được CSV
        if (!session('user_logged_in') || session('user_email') !== 'admin@hotel.com') {
            return redirect('/')->with('error', 'Bạn không có quyền xuất dữ liệu!');
        }

        $query = Booking::with('room');

        // Áp dụng các filter tương tự như index
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $bookings = $query->orderBy('created_at', 'desc')->get();

        // Tạo file CSV
        $filename = 'booking_history_' . date('Y-m-d_H-i-s') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($bookings) {
            $file = fopen('php://output', 'w');
            
            // Header CSV
            fputcsv($file, [
                'ID', 'Tên khách hàng', 'Email', 'SĐT', 'Phòng', 
                'Ngày nhận', 'Ngày trả', 'Số khách', 'Tổng tiền', 'Trạng thái', 'Ngày tạo'
            ]);

            // Dữ liệu
            foreach ($bookings as $booking) {
                fputcsv($file, [
                    $booking->id,
                    $booking->customer_name,
                    $booking->customer_email,
                    $booking->customer_phone,
                    $booking->room->name ?? 'N/A',
                    $booking->checkin,
                    $booking->checkout,
                    $booking->guests,
                    number_format($booking->total_price) . ' VNĐ',
                    $this->getStatusText($booking->status),
                    $booking->created_at->format('d/m/Y H:i')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function getStatusText($status)
    {
        $statusMap = [
            'pending' => 'Chờ xác nhận',
            'confirmed' => 'Đã xác nhận',
            'cancelled' => 'Đã hủy',
            'completed' => 'Hoàn thành'
        ];

        return $statusMap[$status] ?? $status;
    }
}
