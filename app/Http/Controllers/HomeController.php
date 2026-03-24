<?php

namespace App\Http\Controllers;

use App\Models\Room;

class HomeController extends Controller
{
    public function index()
    {
        // Lấy 4 phòng nổi bật (chỉ phòng trống)
        $featuredRooms = Room::where('status', 'available')->orderBy('price', 'desc')->take(4)->get();
        
        return view('home', compact('featuredRooms'));
    }
} 