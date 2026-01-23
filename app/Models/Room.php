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
        'check_out_date',
        'check_out_time',
        'overtime',
        'overtime_hours',
        'guest_name',
        'email',
        'phone',
        'cart_id',
        'photo',
        'deposit',
        'number_of_guests',
        'notes',
        'original_status',
        'booking_expiry',
        'gender',
        'age',
        'address',
        'guest_type',
        'id_type',
        'country',
        'payment_method',
        'children_count'
    ];

    protected $casts = [
        'base_price' => 'decimal:2',
        'deposit' => 'decimal:2',
        'overtime_hours' => 'integer',
        'booking_expiry' => 'datetime',
        'check_in_date' => 'date',
        'check_out_date' => 'date',
        'number_of_guests' => 'integer',
        'children_count' => 'integer',
        'age' => 'integer',
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
