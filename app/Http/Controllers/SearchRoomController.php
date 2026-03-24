<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Room;

class SearchRoomController extends Controller
{
    public function index(Request $request)
    {
        $query = Room::query();

        // Chỉ hiển thị phòng trống
        $query->where('status', 'available');

        // Filter theo loại phòng
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter theo số khách
        if ($request->filled('guests')) {
            $query->where('max_guests', '>=', $request->guests);
        }

        // Filter theo khoảng giá (nếu có)
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Sắp xếp theo giá (mặc định)
        $query->orderBy('price', 'asc');

        $rooms = $query->get();

        return view('search-room', compact('rooms'));
    }
}
