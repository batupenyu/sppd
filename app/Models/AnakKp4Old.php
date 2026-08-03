<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnakKp4Old extends Model
{
    protected $table = 'anak_kp4_olds';

    protected $fillable = [
        'surat_kp4_old_id',
        'name',
        'anak',
        'tgl_lahir',
        'perkawinan',
        'status_sekolah',
        'status_beasiswa',
        'pekerjaan',
        'kat',
        'tgl_meninggal_cerai',
    ];

    protected $casts = [
        'tgl_lahir' => 'date',
        'tgl_meninggal_cerai' => 'date',
        'kat' => 'integer',
    ];

    public function suratKp4Old(): BelongsTo
    {
        return $this->belongsTo(SuratKp4Old::class);
    }
}
