<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pupuk extends Model
{
    protected $table = 'pupuk';

    protected $fillable = [
        'nama_pupuk',
        'deskripsi',
        'image'
    ];
    
}