<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Spd extends Model
{
    protected $fillable = [
        'asn_id',
        'nomor',
        'lembar_ke',
        'kode_no',
        'pejabat_pemberi_tugas',
        'nama',
        'nip',
        'pangkat_golongan',
        'jabatan_instansi',
        'tingkat_biaya',
        'maksud_perjalanan',
        'alat_angkut',
        'tempat_berangkat',
        'tempat_tujuan',
        'lama_perjalanan',
        'tanggal_berangkat',
        'tanggal_kembali',
        'instansi',
        'akun',
        'keterangan_lain',
        'dikeluarkan_di',
        'tanggal_dikeluarkan',
    ];

    protected $casts = [
        'tanggal_berangkat' => 'date',
        'tanggal_kembali' => 'date',
        'tanggal_dikeluarkan' => 'date',
    ];

    public function asn(): BelongsTo
    {
        return $this->belongsTo(Asn::class);
    }
}
