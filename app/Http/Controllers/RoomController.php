<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;

class RoomController extends Controller
{
    public function show($id)
    {
        $room = Room::findOrFail($id);
        return view('room-detail', compact('room'));
    }
}
