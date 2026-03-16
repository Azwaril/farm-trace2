<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lahan extends Model
{
    protected $table = 'lahan';

    protected $fillable = [
        'users_id',
        'nama_lahan',
        'lokasi',
        'luas_lahan'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'users_id');
    }

    public function penanaman()
    {
        return $this->hasMany(Penanaman::class,'lahan_id');
    }
}