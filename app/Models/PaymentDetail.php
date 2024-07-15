<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentDetail extends Model
{
    use HasFactory;
    protected $table = 'payment_details';
    protected $primaryKey = 'id_payment_detail';
    protected $fillable = [
        'id_payment',
        'tgl_payment',
        'deposit',
        'metode_bayar',
        'user_id',
    ];
    // Define the relationship with payment
    public function payment()
    {
        return $this->belongsTo(Payment::class, 'id_payment');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
