<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratTugas extends Model
{
    protected $fillable = [
        'nomor',
        'dasar',
        'peserta',
        'dasar_1',
        'dasar_2',
        'nama_1',
        'pangkat_golongan_1',
        'nip_1',
        'jabatan_1',
        'nama_2',
        'pangkat_golongan_2',
        'nip_2',
        'jabatan_2',
        'untuk_1',
        'untuk_2',
        'untuk_3',
        'dikeluarkan_di',
        'tanggal_dikeluarkan',
        'penandatangan_id',
        'jabatan_penandatangan',
        'nama_penandatangan',
        'nip_penandatangan',
    ];

    protected $casts = [
        'peserta' => 'array',
        'tanggal_dikeluarkan' => 'date',
    ];

    public function penandatangan(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Asn::class, 'penandatangan_id');
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
