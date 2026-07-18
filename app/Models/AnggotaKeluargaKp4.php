<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnggotaKeluargaKp4 extends Model
{
    protected $table = 'anggota_keluarga_kp4s';

    protected $fillable = [
        'surat_kp4_id',
        'nama',
        'tanggal_kelahiran',
        'tanggal_perkawinan',
        'pekerjaan',
        'keterangan',
        'mendapat_tunjangan',
    ];

    protected $casts = [
        'tanggal_kelahiran' => 'date',
        'tanggal_perkawinan' => 'date',
        'mendapat_tunjangan' => 'boolean',
    ];

    public function suratKp4(): BelongsTo
    {
        return $this->belongsTo(SuratKp4::class);
    }
}
