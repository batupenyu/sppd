<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SuratPanggilanSiswa extends Model
{
    protected $table = 'surat_panggilan_siswas';

    protected $fillable = [
        'nomor_surat',
        'siswa_id',
        'keterangan_panggilan',
        'tanggal_panggilan',
        'waktu_panggilan',
        'tempat_panggilan',
        'wali_kelas_id',
        'guru_bk_id',
        'wakasek_kesiswaan_id',
        'tempat_ditetapkan',
        'tanggal_ditetapkan',
    ];

    protected $casts = [
        'tanggal_panggilan' => 'date',
        'tanggal_ditetapkan' => 'date',
    ];

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(DataSiswa::class, 'siswa_id');
    }

    public function waliKelas(): BelongsTo
    {
        return $this->belongsTo(Asn::class, 'wali_kelas_id');
    }

    public function guruBk(): BelongsTo
    {
        return $this->belongsTo(Asn::class, 'guru_bk_id');
    }

    public function wakasekKesiswaan(): BelongsTo
    {
        return $this->belongsTo(Asn::class, 'wakasek_kesiswaan_id');
    }

    public function getKeteranganPanggilanDisplayAttribute(): string
    {
        return match ($this->keterangan_panggilan) {
            'perilaku' => 'Perilaku',
            'acara' => 'Acara',
            default => ucfirst($this->keterangan_panggilan ?? ''),
        };
    }
}
