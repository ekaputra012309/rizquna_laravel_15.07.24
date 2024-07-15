<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use HasFactory;
    protected $table = 'agents';
    protected $primaryKey = 'id_agent';
    // Define fillable columns
    protected $fillable = [
        'nama_agent',
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
