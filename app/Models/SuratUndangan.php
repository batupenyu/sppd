<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SuratUndangan extends Model
{
    protected $table = 'surat_undangans';

    protected $fillable = [
        'nomor_surat',
        'perihal',
        'kepada_yth',
        'siswa_id',
        'tanggal',
        'waktu',
        'tempat',
        'acara',
        'pembuka_surat',
        'penutup_surat',
        'kepala_sekolah_id',
        'tempat_ditetapkan',
        'tanggal_ditetapkan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'tanggal_ditetapkan' => 'date',
    ];

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(DataSiswa::class, 'siswa_id');
    }

    public function kepalaSekolah(): BelongsTo
    {
        return $this->belongsTo(Asn::class, 'kepala_sekolah_id');
    }
}
