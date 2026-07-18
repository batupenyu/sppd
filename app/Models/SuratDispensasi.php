<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SuratDispensasi extends Model
{
    protected $table = 'surat_dispensasis';

    protected $fillable = [
        'nomor_surat',
        'nama_kegiatan',
        'hari_tanggal',
        'waktu',
        'tempat',
        'tempat_ditetapkan',
        'tanggal_ditetapkan',
        'penandatangan_id',
    ];

    protected $casts = [
        'tanggal_ditetapkan' => 'date',
    ];

    public function penandatangan(): BelongsTo
    {
        return $this->belongsTo(Asn::class, 'penandatangan_id');
    }

    public function pesertaDispensasis(): HasMany
    {
        return $this->hasMany(PesertaDispensasi::class);
    }
}
