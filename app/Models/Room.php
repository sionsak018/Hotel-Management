<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'type',
        'floor',
        'base_price',
        'status',
        'guests',
        'stay_type',
        'check_in_date',
        'check_in_time',
        'overtime',
        'guest_name',
        'phone',
        'deposit',
        'notes'
    ];

    protected $casts = [
        'base_price' => 'decimal:2',
        'deposit' => 'decimal:2',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function currentBooking()
    {
        return $this->hasOne(Booking::class)->whereIn('status', ['confirmed', 'checked_in']);
    }
}
