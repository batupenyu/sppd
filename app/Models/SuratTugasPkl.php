<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SuratTugasPkl extends Model
{
    protected $fillable = [
        'nomor',
        'dasar',
        'pegawai_ids',
        'siswa_ids',
        'untuk_1',
        'untuk_2',
        'untuk_3',
        'untuk_4',
        'untuk_5',
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
        'penandatangan_plt',
        'penandatangan_an',
    ];

    protected $casts = [
        'pegawai_ids' => 'array',
        'siswa_ids' => 'array',
        'tanggal_dikeluarkan' => 'date',
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'penandatangan_plt' => 'boolean',
        'penandatangan_an' => 'boolean',
    ];

    public function penandatangan(): BelongsTo
    {
        return $this->belongsTo(Asn::class, 'penandatangan_id');
    }

    public function getPegawai(): array
    {
        $ids = $this->pegawai_ids ?? [];
        if (empty($ids)) {
            return [];
        }

        $pegawai = Asn::whereIn('id', $ids)->get();
        $order = array_flip($ids);

        return $pegawai->sortBy(fn ($p) => $order[$p->id] ?? 0)->values()->all();
    }

    public function getSiswa(): array
    {
        $ids = $this->siswa_ids ?? [];
        if (empty($ids)) {
            return [];
        }

        $siswa = DataSiswa::whereIn('id', $ids)->get();
        $order = array_flip($ids);

        return $siswa->sortBy(fn ($s) => $order[$s->id] ?? 0)->values()->all();
    }
}
