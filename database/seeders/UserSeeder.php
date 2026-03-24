<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Chỉ tạo user admin mẫu
        User::create([
            'name' => 'Admin',
            'email' => 'admin@hotel.com',
            'password' => Hash::make('123456'),
            'phone' => '0123456789',
            'role' => 'admin',
            'position' => 'manager',
            'address' => '123 Đường ABC, Quận 1, TP.HCM'
        ]);
    }
}
