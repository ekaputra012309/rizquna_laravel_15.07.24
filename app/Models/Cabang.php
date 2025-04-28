<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{
    use HasFactory;
    protected $table = 'cabang';
    // Define fillable columns
    protected $fillable = [
        'nama_cabang',
        'user_id',
        // Add other columns as needed
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
