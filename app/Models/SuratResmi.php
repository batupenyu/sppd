<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SuratResmi extends Model
{
    protected $table = 'surat_resmis';

    protected $fillable = [
        'nomor',
        'sifat',
        'lampiran',
        'perihal',
        'pejabat_tujuan_surat',
        'kota_tujuan_surat',
        'pembuka_surat',
        'isi_surat',
        'penutup_surat',
        'tanggal_kegiatan',
        'waktu_kegiatan',
        'tempat_kegiatan',
        'tempat_ditetapkan',
        'tanggal_ditetapkan',
        'penandatangan_id',
    ];

    protected $casts = [
        'tanggal_kegiatan' => 'date',
        'tanggal_ditetapkan' => 'date',
    ];

    public function pegawai(): BelongsToMany
    {
        return $this->belongsToMany(Asn::class, 'surat_resmi_pegawai', 'surat_resmi_id', 'asn_id')
            ->withTimestamps();
    }

    public function penandatangan(): BelongsTo
    {
        return $this->belongsTo(Asn::class, 'penandatangan_id');
    }
}
