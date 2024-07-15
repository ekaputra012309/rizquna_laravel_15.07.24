<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visa extends Model
{
    use HasFactory;
    protected $table = 'visas';
    protected $primaryKey = 'id_visa';
    protected $fillable = [
        'visa_id',
        'tgl_visa',
        'agent_id',
        'tgl_keberangkatan',
        'jumlah_pax',
        'harga_pax',
        'total',
        'status',
        'user_id',
    ];

    // Define the relationship with VisaDetail
    public function details()
    {
        return $this->hasMany(VisaDetail::class, 'id_visa', 'id_visa');
    }
    public function agent()
    {
        return $this->belongsTo(Agent::class, 'agent_id', 'id_agent');
    }
    public function kurs()
    {
        return $this->belongsTo(KursVisa::class, 'id_visa', 'id_visa');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
