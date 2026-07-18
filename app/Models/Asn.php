<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asn extends Model
{
    protected $fillable = [
        'nama',
        'jabatan',
        'nuptk',
        'jk',
        'tempat_lahir',
        'tanggal_lahir',
        'nip',
        'status_kepegawaian',
        'jenis_ptk',
        'agama',
        'alamat_jalan',
        'rt',
        'rw',
        'nama_dusun',
        'desa_kelurahan',
        'kecamatan',
        'kode_pos',
        'telepon',
        'hp',
        'email',
        'tugas_tambahan',
        'sk_cpns',
        'tanggal_cpns',
        'sk_pengangkatan',
        'tmt_pengangkatan',
        'lembaga_pengangkatan',
        'pangkat_golongan',
        'sumber_gaji',
        'nama_ibu_kandung',
        'status_perkawinan',
        'nama_suami_istri',
        'nip_suami_istri',
        'pekerjaan_suami_istri',
        'tmt_pns',
        'sudah_lisensi_kepala_sekolah',
        'pernah_diklat_kepengawasan',
        'keahlian_braille',
        'keahlian_bahasa_isyarat',
        'npwp',
        'nama_wajib_pajak',
        'kewarganegaraan',
        'bank',
        'nomor_rekening_bank',
        'rekening_atas_nama',
        'nik',
        'no_kk',
        'karpeg',
        'karis_karsu',
        'lintang',
        'bujur',
        'nuks',
    ];

    public function getPangkatAttribute(): string
    {
        if (!$this->pangkat_golongan) {
            return '';
        }

        $parts = explode(',', $this->pangkat_golongan, 2);

        return trim($parts[0]);
    }

    public function getGolonganAttribute(): string
    {
        if (!$this->pangkat_golongan) {
            return '';
        }

        $parts = explode(',', $this->pangkat_golongan, 2);

        return isset($parts[1]) ? trim($parts[1]) : '';
    }
}
