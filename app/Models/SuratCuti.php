<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SuratCuti extends Model
{
    protected $table = 'surat_cutis';

    protected $fillable = [
        'nomor_surat',
        'sifat_surat',
        'lampiran_surat',
        'perihal_surat',
        'jenis_cuti',
        'tujuan_surat',
        'tempat_ditetapkan',
        'tanggal_surat',
        'alasan_cuti',
        'tanggal_mulai_cuti',
        'tanggal_selesai_cuti',
        'pegawai_id',
        'penandatangan_id',
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
        'tanggal_mulai_cuti' => 'date',
        'tanggal_selesai_cuti' => 'date',
    ];

    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Asn::class, 'pegawai_id');
    }

    public function penandatangan(): BelongsTo
    {
        return $this->belongsTo(Asn::class, 'penandatangan_id');
    }
}
