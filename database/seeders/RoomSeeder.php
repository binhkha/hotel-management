<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomSeeder extends Seeder
{
    public function run()
    {
        // Xóa dữ liệu cũ
        Room::truncate();

        $rooms = [
            [
                'name' => 'Phòng Standard',
                'image' => 'room4.jpg',
                'type' => 'standard',
                'max_guests' => 2,
                'price' => 400000,
                'description' => 'Phòng tiêu chuẩn với đầy đủ tiện nghi cơ bản, phù hợp cho khách du lịch tiết kiệm.'
            ],
            [
                'name' => 'Phòng Superior Hướng Vườn',
                'image' => 'room2.jpg',
                'type' => 'superior',
                'max_guests' => 3,
                'price' => 600000,
                'description' => 'Phòng superior với view hướng vườn yên tĩnh, không gian rộng rãi và tiện nghi hiện đại.'
            ],
            [
                'name' => 'Phòng Deluxe Hướng Thành Phố',
                'image' => 'room1.jpg',
                'type' => 'deluxe',
                'max_guests' => 3,
                'price' => 800000,
                'description' => 'Phòng deluxe cao cấp với view thành phố tuyệt đẹp, nội thất sang trọng.'
            ],
            [
                'name' => 'Phòng Suite Premium',
                'image' => 'room3.jpg',
                'type' => 'suite',
                'max_guests' => 4,
                'price' => 1200000,
                'description' => 'Phòng suite cao cấp nhất với không gian rộng rãi, phòng khách riêng biệt và view toàn cảnh.'
            ],
            [
                'name' => 'Phòng Deluxe Hướng Biển',
                'image' => 'superior.jpg',
                'type' => 'deluxe',
                'max_guests' => 3,
                'price' => 900000,
                'description' => 'Phòng deluxe với view hướng biển tuyệt đẹp, không gian thoáng đãng và tiện nghi đầy đủ.'
            ],
            [
                'name' => 'Phòng Superior Hướng Núi',
                'image' => 'room1.jpg',
                'type' => 'superior',
                'max_guests' => 2,
                'price' => 550000,
                'description' => 'Phòng superior với view hướng núi yên tĩnh, không khí trong lành và không gian thoải mái.'
            ]
        ];

        foreach ($rooms as $room) {
            Room::create($room);
        }
    }
} 