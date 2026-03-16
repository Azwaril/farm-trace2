<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatPupuk extends Model
{
    protected $table = 'riwayat_pupuk';

    protected $fillable = [
        'penanaman_id',
        'pupuk_id',
        'tanggal_pemupukan',
        'dosis'
    ];

    public function penanaman()
    {
        return $this->belongsTo(Penanaman::class);
    }

    public function pupuk()
    {
        return $this->belongsTo(Pupuk::class);
    }
}