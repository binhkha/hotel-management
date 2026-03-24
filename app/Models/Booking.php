<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'customer_name',
        'customer_phone',
        'customer_email',
        'checkin',
        'checkout',
        'nights',
        'guests',
        'price_per_night',
        'total_price',
        'notes',
        'status'
    ];

    protected $casts = [
        'checkin' => 'date',
        'checkout' => 'date',
        'price_per_night' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
