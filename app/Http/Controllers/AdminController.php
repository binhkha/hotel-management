<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Booking;

class AdminController extends Controller
{
    public function __construct()
    {
        // Kiểm tra quyền admin trước khi thực hiện bất kỳ action nào
        $this->middleware(function ($request, $next) {
            if (!session('user_logged_in') || session('user_email') !== 'admin@hotel.com') {
                return redirect('/')->with('error', 'Bạn không có quyền truy cập trang này!');
            }
            return $next($request);
        });
    }

    public function rooms()
    {
        $rooms = Room::orderBy('id', 'desc')->get();
        return view('admin.rooms', compact('rooms'));
    }

    public function bookings()
    {
        // Lấy tất cả đơn đặt phòng từ database
        $bookings = Booking::with('room')->orderBy('created_at', 'desc')->get();
        return view('admin.bookings', compact('bookings'));
    }

    public function updateBookingStatus(Request $request, $bookingId)
    {
        // Debug log
        \Log::info('Update booking status request:', [
            'booking_id' => $bookingId,
            'status' => $request->input('status'),
            'request_data' => $request->all(),
            'method' => $request->method()
        ]);
        
        $status = $request->input('status');
        $booking = Booking::findOrFail($bookingId);
        $oldStatus = $booking->status;
        
        $booking->update(['status' => $status]);
        
        // Cập nhật trạng thái phòng dựa trên trạng thái đơn đặt phòng
        $room = $booking->room;
        
        if ($room) {
            if ($status === 'confirmed' && $oldStatus !== 'confirmed') {
                // Khi xác nhận đơn đặt phòng, phòng chuyển thành "đã thuê"
                $room->update(['status' => 'occupied']);
            } elseif ($status === 'cancelled' && $oldStatus === 'confirmed') {
                // Khi hủy đơn đã xác nhận, phòng chuyển thành "trống"
                $room->update(['status' => 'available']);
            } elseif ($status === 'completed' && $oldStatus === 'confirmed') {
                // Khi hoàn thành, phòng chuyển thành "trống"
                $room->update(['status' => 'available']);
            }
        }
        
        // Debug log khi thành công
        \Log::info('Booking status updated successfully:', [
            'booking_id' => $bookingId,
            'old_status' => $oldStatus,
            'new_status' => $status
        ]);
        
        return response()->json(['success' => true, 'message' => 'Cập nhật trạng thái thành công!']);
    }

    public function deleteBooking($bookingId)
    {
        $booking = Booking::findOrFail($bookingId);
        
        // Cập nhật trạng thái phòng về "trống" nếu đơn đặt phòng đã xác nhận
        if ($booking->status === 'confirmed') {
            $room = $booking->room;
            if ($room) {
                $room->update(['status' => 'available']);
            }
        }
        
        $booking->delete();
        
        return response()->json(['success' => true, 'message' => 'Xóa đơn đặt phòng thành công!']);
    }

    public function storeRoom(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:standard,superior,deluxe,suite',
            'max_guests' => 'required|integer|min:1|max:10',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Xử lý upload hình ảnh
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('images'), $imageName);

        // Tạo phòng mới
        Room::create([
            'name' => $request->name,
            'type' => $request->type,
            'max_guests' => $request->max_guests,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $imageName,
            'status' => 'available'
        ]);

        return redirect()->back()->with('success', 'Thêm phòng thành công!');
    }

    public function updateRoomStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:available,occupied,maintenance'
        ]);

        $room = Room::findOrFail($id);
        $room->update(['status' => $request->status]);

        return response()->json([
            'success' => true, 
            'message' => 'Cập nhật trạng thái phòng thành công!'
        ]);
    }

    public function deleteRoom($id)
    {
        $room = Room::findOrFail($id);
        
        // Xóa hình ảnh cũ
        if (file_exists(public_path('images/' . $room->image))) {
            unlink(public_path('images/' . $room->image));
        }
        
        $room->delete();
        
        return response()->json(['success' => true]);
    }
} 