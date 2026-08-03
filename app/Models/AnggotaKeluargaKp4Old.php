<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnggotaKeluargaKp4Old extends Model
{
    protected $table = 'anggota_keluarga_kp4_olds';

    protected $fillable = [
        'surat_kp4_old_id',
        'nama',
        'nama_suami_istri',
        'tanggal_kelahiran',
        'tanggal_perkawinan',
        'pekerjaan',
        'penghasilan_sebulan',
        'keterangan',
        'mendapat_tunjangan',
    ];

    protected $casts = [
        'tanggal_kelahiran' => 'date',
        'tanggal_perkawinan' => 'date',
        'mendapat_tunjangan' => 'boolean',
    ];

    public function suratKp4Old(): BelongsTo
    {
        return $this->belongsTo(SuratKp4Old::class);
    }
}
