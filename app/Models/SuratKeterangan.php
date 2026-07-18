<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SuratKeterangan extends Model
{
    protected $table = 'surat_keterangans';

    protected $fillable = [
        'nomor_surat',
        'isi_surat',
        'tempat_ditetapkan',
        'tanggal_ditetapkan',
        'pegawai_id',
        'siswa_id',
        'penandatangan_id',
    ];

    protected $casts = [
        'tanggal_ditetapkan' => 'date',
    ];

    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Asn::class, 'pegawai_id');
    }

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(DataSiswa::class, 'siswa_id');
    }

    public function penandatangan(): BelongsTo
    {
        return $this->belongsTo(Asn::class, 'penandatangan_id');
    }
}
