<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'kegiatan',
        'tanggal_mulai',
        'tanggal_selesai',
        'pukul',
        'tempat',
        'sumber_dana',
        'tahun_anggaran',
        'dikeluarkan_di',
        'tanggal_dikeluarkan',
        'penandatangan_id',
        'nama_penandatangan',
        'nip_penandatangan',
    ];

    protected $casts = [
        'peserta' => 'array',
        'tanggal_dikeluarkan' => 'date',
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    public function penandatangan(): BelongsTo
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
