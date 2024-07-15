<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    protected $table = 'rooms';
    protected $primaryKey = 'id_kamar';
    // Define fillable columns
    protected $fillable = [
        'kamar_id',
        'keterangan',
        'user_id',
        // Add other columns as needed
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
