<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'id_card_number',
        'id_card_image',
        'total_stays'
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
