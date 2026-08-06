<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SuratPenarikanSiswa extends Model
{
    protected $table = 'surat_penarikan_siswas';

    protected $fillable = [
        'nomor_surat',
        'nama_sekolah_asal',
        'nama_siswa',
        'nis',
        'nisn',
        'kelas_jurusan',
        'nama_orang_tua',
        'pekerjaan_orang_tua',
        'alamat_rumah',
        'no_hp',
        'tempat_tanggal_lahir',
        'nama_sekolah_tujuan',
        'alasan',
        'nama_kota_sekolah',
        'tanggal_surat',
        'nama_wilayah_cabdinas',
        'nama_kota_cabdin',
        'nomor_surat_cabdin',
        'tanggal_ditetapkan',
        'pegawai_id',
        'penandatangan_id',
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
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
