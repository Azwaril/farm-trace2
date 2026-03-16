<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Panen extends Model
{
    protected $table = 'panen';

    protected $fillable = [
        'penanaman_id',
        'tanggal_panen',
        'jumlah_panen',
        'satuan'
    ];
}