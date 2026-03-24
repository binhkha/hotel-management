<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'rooms';
    protected $fillable = ['name', 'image', 'type', 'max_guests', 'price', 'description', 'status'];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}



