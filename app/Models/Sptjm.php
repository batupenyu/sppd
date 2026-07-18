<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Sptjm extends Model
{
    protected $table = 'sptjms';

    protected $fillable = [
        'nomor_surat',
        'penandatangan_id',
        'isi_surat',
        'penutup_surat',
        'tempat_ditetapkan',
        'tanggal_ditetapkan',
    ];

    protected $casts = [
        'tanggal_ditetapkan' => 'date',
    ];

    public function penandatangan(): BelongsTo
    {
        return $this->belongsTo(Asn::class, 'penandatangan_id');
    }

    public function pegawai(): BelongsToMany
    {
        return $this->belongsToMany(Asn::class, 'sptjm_pegawai', 'sptjm_id', 'asn_id')
            ->withTimestamps();
    }
}
