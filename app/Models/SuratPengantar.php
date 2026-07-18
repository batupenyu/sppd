<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SuratPengantar extends Model
{
    protected $table = 'surat_pengantars';

    protected $fillable = [
        'nomor_surat',
        'tujuan_surat',
        'isi_surat',
        'banyaknya',
        'keterangan',
        'tempat_ditetapkan',
        'tanggal_ditetapkan',
        'nomor_telepon',
        'penandatangan_id',
    ];

    protected $casts = [
        'tanggal_ditetapkan' => 'date',
    ];

    public function penandatangan(): BelongsTo
    {
        return $this->belongsTo(Asn::class, 'penandatangan_id');
    }
}
