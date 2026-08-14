<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PersetujuanMagang extends Model
{
    protected $table = 'persetujuan_magangs';

    protected $fillable = [
        'nomor_surat',
        'sifat',
        'lampiran',
        'perihal',
        'tujuan_surat',
        'nomor_surat_kampus',
        'tanggal_surat_kampus',
        'nama_instansi',
        'alamat_instansi',
        'tanggal_mulai',
        'tanggal_selesai',
        'mahasiswas',
        'tempat_ditetapkan',
        'tanggal_ditetapkan',
        'penandatangan_id',
    ];

    protected $casts = [
        'tanggal_surat_kampus' => 'date',
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'tanggal_ditetapkan' => 'date',
        'mahasiswas' => 'array',
    ];

    public function penandatangan(): BelongsTo
    {
        return $this->belongsTo(Asn::class, 'penandatangan_id');
    }
}
