<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Booking;

class BookingController extends Controller
{
    public function bookRoom(Request $request)
    {
        // Debug: Log request data
        \Log::info('Booking request:', $request->all());
        
        // Kiểm tra đăng nhập
        if (!session('user_logged_in')) {
            return redirect('/')->with('error', 'Vui lòng đăng nhập để đặt phòng!');
        }

        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'checkin' => 'required|date|after_or_equal:today',
            'checkout' => 'required|date|after:checkin',
            'guests' => 'required|integer|min:1',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'notes' => 'nullable|string'
        ]);

        $room = Room::findOrFail($request->room_id);
        
        // Kiểm tra trạng thái phòng
        if ($room->status !== 'available') {
            $statusText = $room->status === 'occupied' ? 'đã có người thuê' : 'đang bảo trì';
            return redirect()->back()->with('error', "Phòng này {$statusText}, vui lòng chọn phòng khác!");
        }
        
        // Kiểm tra số khách không vượt quá giới hạn
        if ($request->guests > $room->max_guests) {
            return redirect()->back()->with('error', 'Số khách vượt quá giới hạn cho phép!');
        }

        // Tính số đêm
        $checkin = \Carbon\Carbon::parse($request->checkin);
        $checkout = \Carbon\Carbon::parse($request->checkout);
        $nights = $checkin->diffInDays($checkout);
        
        // Debug: Log date calculation
        \Log::info('Date calculation:', [
            'checkin' => $request->checkin,
            'checkout' => $request->checkout,
            'nights' => $nights
        ]);
        
        // Tính tổng tiền
        $totalPrice = $nights * $room->price;

        try {
            // Tạo đơn đặt phòng mới trong database
            $booking = Booking::create([
                'room_id' => $room->id,
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'customer_email' => session('user_email'), // Tự động lấy email từ session đăng nhập
                'checkin' => $request->checkin,
                'checkout' => $request->checkout,
                'nights' => $nights,
                'guests' => $request->guests,
                'price_per_night' => $room->price,
                'total_price' => $totalPrice,
                'notes' => $request->notes,
                'status' => 'pending'
            ]);

            // Cập nhật trạng thái phòng thành "đã thuê"
            $room->update(['status' => 'occupied']);

            // Lưu thông tin đơn đặt phòng hiện tại vào session để hiển thị trang xác nhận
            session(['current_booking_id' => $booking->id]);

            return redirect()->route('booking.confirmation')->with('success', 'Đặt phòng thành công! Chúng tôi sẽ liên hệ với bạn trong vòng 24 giờ để xác nhận.');

        } catch (\Exception $e) {
            // Debug: Log error
            \Log::error('Booking error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi đặt phòng. Vui lòng thử lại!');
        }
    }

    public function confirmation()
    {
        $bookingId = session('current_booking_id');
        
        if (!$bookingId) {
            return redirect('/');
        }

        $booking = Booking::with('room')->find($bookingId);
        
        if (!$booking) {
            return redirect('/');
        }

        return view('booking.confirmation', compact('booking'));
    }
} 