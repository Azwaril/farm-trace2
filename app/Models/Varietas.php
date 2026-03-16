<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Varietas extends Model
{
    protected $table = 'varietas';

    protected $fillable = [
        'tanaman_id',
        'nama_varietas'
    ];

    public function tanaman()
    {
        return $this->belongsTo(Tanaman::class);
    }
}