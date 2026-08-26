<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HariLibur extends Model
{
    protected $fillable = [
        'tanggal',
        'nama',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];
}
