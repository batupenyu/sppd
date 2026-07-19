<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LaporanNodin extends Model
{
    protected $table = 'laporan_nodins';

    protected $fillable = [
        'kepada',
        'dari',
        'nomor',
        'lampiran',
        'tanggal',
        'perihal',
        'dasar_pelaksanaan',
        'tujuan',
        'peserta1_nama',
        'peserta1_nip',
        'peserta1_jabatan',
        'peserta2_nama',
        'peserta2_nip',
        'peserta2_jabatan',
        'pelaksanaan_tanggal',
        'pelaksanaan_jam',
        'pelaksanaan_tempat',
        'kesimpulan',
        'penandatangan_id',
        'kop_surat',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'pelaksanaan_tanggal' => 'date',
    ];

    public function penandatangan(): BelongsTo
    {
        return $this->belongsTo(Asn::class, 'penandatangan_id');
    }
}
