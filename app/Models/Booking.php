<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'guest_id',
        'check_in_date',
        'check_out_date',
        'check_in_time',
        'check_out_time',
        'stay_type',
        'total_amount',
        'deposit',
        'status',
        'payment_method',
        'id_card_image',
        'special_requests'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'deposit' => 'decimal:2',
        'check_in_date' => 'date',
        'check_out_date' => 'date',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
