<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'peserta',
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
        'peserta' => 'array',
    ];

    public function penandatangan(): BelongsTo
    {
        return $this->belongsTo(Asn::class, 'penandatangan_id');
    }

    public function photos(): HasMany
    {
        return $this->hasMany(PhotoNodin::class);
    }

    public function getPeserta(): array
    {
        $ids = $this->peserta ?? [];
        if (empty($ids)) {
            return [];
        }

        $peserta = Asn::whereIn('id', $ids)->get();
        $order = array_flip($ids);

        return $peserta->sortBy(fn ($p) => $order[$p->id] ?? 0)->values()->all();
    }
}
