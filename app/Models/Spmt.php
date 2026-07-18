<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Spmt extends Model
{
    protected $table = 'spmts';

    protected $fillable = [
        'nomor_surat',
        'penandatangan_id',
        'pegawai_id',
        'peraturan',
        'nomor_peraturan',
        'tahun_peraturan',
        'tentang',
        'tanggal_terhitung',
        'sebagai',
        'tempat_tugas',
        'tempat_ditetapkan',
        'tanggal_surat',
    ];

    protected $casts = [
        'tanggal_terhitung' => 'date',
        'tanggal_surat' => 'date',
    ];

    public function penandatangan(): BelongsTo
    {
        return $this->belongsTo(Asn::class, 'penandatangan_id');
    }

    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Asn::class, 'pegawai_id');
    }
}
