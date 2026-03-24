<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\Room;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo 2 đơn đặt phòng mẫu để test
        $room1 = Room::find(1);
        $room2 = Room::find(2);
        
        if ($room1) {
            Booking::create([
                'room_id' => $room1->id,
                'customer_name' => 'Khách hàng mẫu 1',
                'customer_phone' => '0987654321',
                'customer_email' => 'guest1@example.com',
                'checkin' => now()->addDays(2),
                'checkout' => now()->addDays(4),
                'nights' => 2,
                'guests' => 2,
                'price_per_night' => $room1->price,
                'total_price' => $room1->price * 2,
                'notes' => 'Đơn đặt phòng mẫu để test',
                'status' => 'confirmed'
            ]);
        }
        
        if ($room2) {
            Booking::create([
                'room_id' => $room2->id,
                'customer_name' => 'Khách hàng mẫu 2',
                'customer_phone' => '0123456780',
                'checkin' => now()->addDays(5),
                'checkout' => now()->addDays(7),
                'nights' => 2,
                'guests' => 3,
                'price_per_night' => $room2->price,
                'total_price' => $room2->price * 2,
                'notes' => 'Đơn đặt phòng mẫu để test',
                'status' => 'pending'
            ]);
        }
    }
}
