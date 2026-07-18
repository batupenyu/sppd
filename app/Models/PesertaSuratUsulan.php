<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PesertaSuratUsulan extends Model
{
    protected $table = 'peserta_surat_usulans';

    protected $fillable = [
        'surat_nodin_id',
        'pegawai_id',
        'siswa_id',
        'tanggal_kegiatan',
        'tempat_kegiatan',
    ];

    protected $casts = [
        'tanggal_kegiatan' => 'date',
    ];

    public function suratNodin(): BelongsTo
    {
        return $this->belongsTo(SuratNodin::class);
    }

    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Asn::class, 'pegawai_id');
    }

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(DataSiswa::class, 'siswa_id');
    }
}
