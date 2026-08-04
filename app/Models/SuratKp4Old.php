<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SuratKp4Old extends Model
{
    protected $table = 'surat_kp4_olds';

    protected $fillable = [
        'status_kepegawaian',
        'masa_kerja_golongan',
        'digaji_menurut',
        'disamping_jabatan',
        'penghasilan_disamping',
        'pensiun_janda',
        'kawin_sah',
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

    public function anggotaKeluarga(): HasMany
    {
        return $this->hasMany(AnggotaKeluargaKp4Old::class);
    }

    public function anak(): HasMany
    {
        return $this->hasMany(AnakKp4Old::class);
    }
}
