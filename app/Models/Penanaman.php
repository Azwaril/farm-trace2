<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penanaman extends Model
{
    protected $table = 'penanaman';

    protected $fillable = [
        'tanaman_id',
        'lahan_id',
        'varietas_id',
        'tanggal_tanam',
        'catatan'
    ];

    public function lahan()
    {
        return $this->belongsTo(Lahan::class);
    }

    public function tanaman()
    {
        return $this->belongsTo(Tanaman::class);
    }

    public function varietas()
    {
        return $this->belongsTo(Varietas::class);
    }
}