<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SuratUmum extends Model
{
    protected $table = 'surat_umums';

    protected $fillable = [
        'pembuka_surat',
        'isi_surat',
        'penutup_surat',
        'tempat_ditetapkan',
        'tanggal_ditetapkan',
        'pegawai_id',
        'penandatangan_id',
    ];

    protected $casts = [
        'tanggal_ditetapkan' => 'date',
    ];

    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Asn::class, 'pegawai_id');
    }

    public function penandatangan(): BelongsTo
    {
        return $this->belongsTo(Asn::class, 'penandatangan_id');
    }
}
