<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lampiran extends Model
{
    protected $fillable = [
        'judul',
        'nomor',
        'tanggal',
        'keterangan',
        'pegawai_ids',
        'siswa_ids',
        'penandatangan_id',
        'penandatangan_an',
    ];

    protected $casts = [
        'pegawai_ids' => 'array',
        'siswa_ids' => 'array',
        'tanggal' => 'date',
        'penandatangan_an' => 'boolean',
    ];

    public function penandatangan()
    {
        return $this->belongsTo(Asn::class, 'penandatangan_id');
    }

    public function getPegawaiList()
    {
        $ids = $this->pegawai_ids ?? [];
        if (empty($ids)) {
            return collect();
        }

        return Asn::whereIn('id', $ids)->get()->sortBy(fn ($p) => array_flip($ids)[$p->id] ?? 0)->values();
    }

    public function getSiswaList()
    {
        $ids = $this->siswa_ids ?? [];
        if (empty($ids)) {
            return collect();
        }

        return DataSiswa::whereIn('id', $ids)->get()->sortBy(fn ($s) => array_flip($ids)[$s->id] ?? 0)->values();
    }
}
