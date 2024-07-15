<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingDetail extends Model
{
    use HasFactory;
    protected $table = 'booking_details';
    protected $primaryKey = 'id_booking_detail';
    protected $fillable = [
        'booking_id',
        'room_id',
        'qty',
        'malam',
        'tarif',
        'discount',
        'subtotal',
        'user_id',
    ];

    // Define the inverse relationship with Booking
    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'booking_id');
    }

    // Define the relationship with Room
    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
