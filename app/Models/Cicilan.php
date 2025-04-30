<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cicilan extends Model
{
    use HasFactory;
    protected $table = 'cicilan';

    protected $fillable = [
        'id_jamaah', 'tgl_cicil', 'deposit', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jamaah()
    {
        return $this->belongsTo(Jamaah::class, 'id_jamaah');
    }
}
