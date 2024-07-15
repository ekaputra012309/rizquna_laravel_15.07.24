<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;
    protected $table = 'hotels';
    protected $primaryKey = 'id_hotel';
    // Define fillable columns
    protected $fillable = [
        'nama_hotel',
        'alamat',
        'contact_person',
        'telepon',
        'user_id',
        // Add other columns as needed
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
