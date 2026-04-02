<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tanaman extends Model
{
    protected $table = 'tanaman';

    protected $fillable = [
        'users_id',
        'nama_tanaman',
        'deskripsi',
        'image'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}