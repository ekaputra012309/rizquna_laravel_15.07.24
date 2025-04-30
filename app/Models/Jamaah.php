<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jamaah extends Model
{
    use HasFactory;
    protected $table = 'jamaah';

    protected $fillable = [
        'nik', 'nama', 'alamat', 'phone', 'passpor', 'dp',
        'tgl_berangkat', 'user_id', 'cabang_id', 'agent_id',
        'paket_id', 'updateby', 'updatetime', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class, 'agent_id', 'id_agent');
    }

    public function paket()
    {
        return $this->belongsTo(Paket::class);
    }

    public function cicilan()
    {
        return $this->hasMany(Cicilan::class, 'id_jamaah');
    }
}
