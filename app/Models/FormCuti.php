<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FormCuti extends Model
{
    protected $table = 'form_cutis';

    protected $fillable = [
        'nomor_surat',
        'jenis_cuti',
        'alasan_cuti',
        'tanggal_mulai_cuti',
        'tanggal_selesai_cuti',
        'jumlah_hari',
        'pegawai_id',
        'kepala_sekolah_id',
        'kepala_cabang_id',
        'alamat_cuti',
        'telepon',
        'plt_plh',
        'plt_plh_kepala_cabang',
    ];

    protected $casts = [
        'tanggal_mulai_cuti' => 'date',
        'tanggal_selesai_cuti' => 'date',
    ];

    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Asn::class, 'pegawai_id');
    }

    public function kepalaSekolah(): BelongsTo
    {
        return $this->belongsTo(Asn::class, 'kepala_sekolah_id');
    }

    public function kepalaCabang(): BelongsTo
    {
        return $this->belongsTo(Asn::class, 'kepala_cabang_id');
    }
}
