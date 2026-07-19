<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SuratNodin extends Model
{
    protected $table = 'surat_nodins';

    protected $fillable = [
        'nomor',
        'sifat',
        'lampiran',
        'hal',
        'kepada',
        'dari',
        'tanggal',
        'dasar_surat',
        'isi_surat',
        'penandatangan_id',
        'tempat_ditetapkan',
        'tanggal_ditetapkan',
        'kop_surat',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'tanggal_ditetapkan' => 'date',
    ];

    public function penandatangan(): BelongsTo
    {
        return $this->belongsTo(Asn::class, 'penandatangan_id');
    }

    public function pesertaSuratUsulans(): HasMany
    {
        return $this->hasMany(PesertaSuratUsulan::class);
    }
}
