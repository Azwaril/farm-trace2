<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Panen extends Model
{
    protected $table = 'panen';

    protected $fillable = [
        'penanaman_id',
        'riwayat_pupuk_id',
        'tanggal_panen',
        'jumlah_panen',
        'satuan'
    ];

    // relasi ke penanaman
    public function penanaman()
    {
        return $this->belongsTo(Penanaman::class);
    }

    // relasi ke riwayat pupuk
    public function riwayat_pupuk()
    {
        return $this->belongsTo(RiwayatPupuk::class);
    }
}