<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $table = 'payments';
    protected $primaryKey = 'id_payment';
    protected $fillable = [
        'id_booking',
        'pilih_konversi',
        'sar_idr',
        'sar_usd',
        'usd_idr',
        'hasil_konversi',
        'user_id',
    ];
    // Define the relationship with booking
    public function booking()
    {
        return $this->belongsTo(Booking::class, 'id_booking', 'id_booking');
    }

    public function detailpay()
    {
        return $this->hasMany(PaymentDetail::class, 'id_payment', 'id_payment');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
