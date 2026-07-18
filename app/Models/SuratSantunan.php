<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SuratSantunan extends Model
{
    protected $table = 'surat_santunans';

    protected $fillable = [
        'nomor_surat',
        'sifat',
        'lampiran',
        'perihal',
        'tempat_ditetapkan',
        'tanggal_ditetapkan',
        'instansi_tujuan_surat',
        'kota_tujuan_surat',
        'isi_surat_pertama',
        'pegawai_id',
        'penandatangan_id',
    ];

    protected $casts = [
        'tanggal_ditetapkan' => 'date',
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
