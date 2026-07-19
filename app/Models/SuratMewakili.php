<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SuratMewakili extends Model
{
    protected $table = 'surat_mewakili';

    protected $fillable = [
        'nomor',
        'penunjuk_id',
        'penunjuk_nama',
        'penunjuk_nip',
        'penunjuk_pangkat_gol',
        'penunjuk_jabatan',
        'ditunjuk_id',
        'ditunjuk_nama',
        'ditunjuk_nip',
        'ditunjuk_instansi',
        'ditunjuk_jabatan',
        'keterangan_menunjuk',
        'keterangan_mewakili',
        'ketentuan',
        'penutup',
        'dikeluarkan_di',
        'tanggal_dikeluarkan',
    ];

    protected $casts = [
        'tanggal_dikeluarkan' => 'date',
        'ketentuan' => 'array',
    ];

    public function penunjuk(): BelongsTo
    {
        return $this->belongsTo(Asn::class, 'penunjuk_id');
    }

    public function ditunjuk(): BelongsTo
    {
        return $this->belongsTo(Asn::class, 'ditunjuk_id');
    }
}
