<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    protected $table = 'artikel';

    protected $fillable = [
        'judul',
        'isi',
        'image',
        'users_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}