<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SuratAktifMengajar extends Model
{
    protected $table = 'surat_aktif_mengajars';

    protected $fillable = [
        'nomor_surat',
        'pegawai_id',
        'penandatangan_id',
        'tempat_ditetapkan',
        'tanggal_ditetapkan',
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
