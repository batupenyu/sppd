@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h1 class="text-2xl font-bold mb-6">Edit Data ASN</h1>

                <form action="{{ route('asns.update', $asn) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <h2 class="text-lg font-semibold mb-4 border-b pb-2">Data Pribadi</h2>
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Nama *</label>
                            <input type="text" name="nama" value="{{ old('nama', $asn->nama) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100" required>
                            @error('nama')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Jabatan</label>
                            <input type="text" name="jabatan" value="{{ old('jabatan', $asn->jabatan) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                            @error('jabatan')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label class="block font-medium mb-1">NUPTK</label>
                            <input type="text" name="nuptk" value="{{ old('nuptk', $asn->nuptk) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                            @error('nuptk')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Jenis Kelamin *</label>
                            <select name="jk" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100" required>
                                <option value="L" {{ old('jk', $asn->jk) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('jk', $asn->jk) == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('jk')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $asn->tempat_lahir) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                            @error('tempat_lahir')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $asn->tanggal_lahir) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                            @error('tanggal_lahir')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label class="block font-medium mb-1">NIP</label>
                            <input type="text" name="nip" value="{{ old('nip', $asn->nip) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                            @error('nip')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Status Kepegawaian</label>
                            <input type="text" name="status_kepegawaian" value="{{ old('status_kepegawaian', $asn->status_kepegawaian) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                            @error('status_kepegawaian')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Jenis PTK</label>
                            <input type="text" name="jenis_ptk" value="{{ old('jenis_ptk', $asn->jenis_ptk) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                            @error('jenis_ptk')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Agama</label>
                            <input type="text" name="agama" value="{{ old('agama', $asn->agama) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                            @error('agama')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label class="block font-medium mb-1">NIK</label>
                            <input type="text" name="nik" value="{{ old('nik', $asn->nik) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                            @error('nik')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label class="block font-medium mb-1">No KK</label>
                            <input type="text" name="no_kk" value="{{ old('no_kk', $asn->no_kk) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                            @error('no_kk')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div class="md:col-span-2">
                            <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Alamat</h2>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block font-medium mb-1">Alamat Jalan</label>
                            <textarea name="alamat_jalan" rows="2" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">{{ old('alamat_jalan', $asn->alamat_jalan) }}</textarea>
                            @error('alamat_jalan')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label class="block font-medium mb-1">RT</label>
                            <input type="text" name="rt" value="{{ old('rt', $asn->rt) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                            @error('rt')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label class="block font-medium mb-1">RW</label>
                            <input type="text" name="rw" value="{{ old('rw', $asn->rw) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                            @error('rw')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Nama Dusun</label>
                            <input type="text" name="nama_dusun" value="{{ old('nama_dusun', $asn->nama_dusun) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                            @error('nama_dusun')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Desa/Kelurahan</label>
                            <input type="text" name="desa_kelurahan" value="{{ old('desa_kelurahan', $asn->desa_kelurahan) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                            @error('desa_kelurahan')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Kecamatan</label>
                            <input type="text" name="kecamatan" value="{{ old('kecamatan', $asn->kecamatan) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                            @error('kecamatan')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Kode Pos</label>
                            <input type="text" name="kode_pos" value="{{ old('kode_pos', $asn->kode_pos) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                            @error('kode_pos')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Telepon</label>
                            <input type="text" name="telepon" value="{{ old('telepon', $asn->telepon) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                            @error('telepon')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label class="block font-medium mb-1">HP</label>
                            <input type="text" name="hp" value="{{ old('hp', $asn->hp) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                            @error('hp')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Email</label>
                            <input type="email" name="email" value="{{ old('email', $asn->email) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                            @error('email')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div class="md:col-span-2">
                            <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Kepegawaian</h2>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block font-medium mb-1">Tugas Tambahan</label>
                            <textarea name="tugas_tambahan" rows="2" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">{{ old('tugas_tambahan', $asn->tugas_tambahan) }}</textarea>
                            @error('tugas_tambahan')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label class="block font-medium mb-1">SK CPNS</label>
                            <input type="text" name="sk_cpns" value="{{ old('sk_cpns', $asn->sk_cpns) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                            @error('sk_cpns')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Tanggal CPNS</label>
                            <input type="date" name="tanggal_cpns" value="{{ old('tanggal_cpns', $asn->tanggal_cpns) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                            @error('tanggal_cpns')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label class="block font-medium mb-1">SK Pengangkatan</label>
                            <input type="text" name="sk_pengangkatan" value="{{ old('sk_pengangkatan', $asn->sk_pengangkatan) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                            @error('sk_pengangkatan')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label class="block font-medium mb-1">TMT Pengangkatan</label>
                            <input type="date" name="tmt_pengangkatan" value="{{ old('tmt_pengangkatan', $asn->tmt_pengangkatan) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                            @error('tmt_pengangkatan')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Lembaga Pengangkatan</label>
                            <input type="text" name="lembaga_pengangkatan" value="{{ old('lembaga_pengangkatan', $asn->lembaga_pengangkatan) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                            @error('lembaga_pengangkatan')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Pangkat Golongan</label>
                            <input type="text" name="pangkat_golongan" value="{{ old('pangkat_golongan', $asn->pangkat_golongan) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                            @error('pangkat_golongan')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Sumber Gaji</label>
                            <input type="text" name="sumber_gaji" value="{{ old('sumber_gaji', $asn->sumber_gaji) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                            @error('sumber_gaji')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label class="block font-medium mb-1">TMT PNS</label>
                            <input type="date" name="tmt_pns" value="{{ old('tmt_pns', $asn->tmt_pns) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                            @error('tmt_pns')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div class="md:col-span-2">
                            <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Keluarga</h2>
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Nama Ibu Kandung</label>
                            <input type="text" name="nama_ibu_kandung" value="{{ old('nama_ibu_kandung', $asn->nama_ibu_kandung) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                            @error('nama_ibu_kandung')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Status Perkawinan</label>
                            <select name="status_perkawinan" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                                <option value="">-- Pilih --</option>
                                <option value="Kawin" {{ old('status_perkawinan', $asn->status_perkawinan) == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                                <option value="Belum Kawin" {{ old('status_perkawinan', $asn->status_perkawinan) == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                                <option value="Cerai Hidup" {{ old('status_perkawinan', $asn->status_perkawinan) == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                                <option value="Cerai Mati" {{ old('status_perkawinan', $asn->status_perkawinan) == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                            </select>
                            @error('status_perkawinan')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Nama Suami/Istri</label>
                            <input type="text" name="nama_suami_istri" value="{{ old('nama_suami_istri', $asn->nama_suami_istri) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                            @error('nama_suami_istri')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label class="block font-medium mb-1">NIP Suami/Istri</label>
                            <input type="text" name="nip_suami_istri" value="{{ old('nip_suami_istri', $asn->nip_suami_istri) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                            @error('nip_suami_istri')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Pekerjaan Suami/Istri</label>
                            <input type="text" name="pekerjaan_suami_istri" value="{{ old('pekerjaan_suami_istri', $asn->pekerjaan_suami_istri) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                            @error('pekerjaan_suami_istri')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div class="md:col-span-2">
                            <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Keahlian</h2>
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Sudah Lisensi Kepala Sekolah</label>
                            <select name="sudah_lisensi_kepala_sekolah" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                                <option value="">-- Pilih --</option>
                                <option value="Ya" {{ old('sudah_lisensi_kepala_sekolah', $asn->sudah_lisensi_kepala_sekolah) == 'Ya' ? 'selected' : '' }}>Ya</option>
                                <option value="Tidak" {{ old('sudah_lisensi_kepala_sekolah', $asn->sudah_lisensi_kepala_sekolah) == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                            </select>
                            @error('sudah_lisensi_kepala_sekolah')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Pernah Diklat Kepengawasan</label>
                            <select name="pernah_diklat_kepengawasan" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                                <option value="">-- Pilih --</option>
                                <option value="Ya" {{ old('pernah_diklat_kepengawasan', $asn->pernah_diklat_kepengawasan) == 'Ya' ? 'selected' : '' }}>Ya</option>
                                <option value="Tidak" {{ old('pernah_diklat_kepengawasan', $asn->pernah_diklat_kepengawasan) == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                            </select>
                            @error('pernah_diklat_kepengawasan')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Keahlian Braille</label>
                            <select name="keahlian_braille" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                                <option value="">-- Pilih --</option>
                                <option value="Ya" {{ old('keahlian_braille', $asn->keahlian_braille) == 'Ya' ? 'selected' : '' }}>Ya</option>
                                <option value="Tidak" {{ old('keahlian_braille', $asn->keahlian_braille) == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                            </select>
                            @error('keahlian_braille')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Keahlian Bahasa Isyarat</label>
                            <select name="keahlian_bahasa_isyarat" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                                <option value="">-- Pilih --</option>
                                <option value="Ya" {{ old('keahlian_bahasa_isyarat', $asn->keahlian_bahasa_isyarat) == 'Ya' ? 'selected' : '' }}>Ya</option>
                                <option value="Tidak" {{ old('keahlian_bahasa_isyarat', $asn->keahlian_bahasa_isyarat) == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                            </select>
                            @error('keahlian_bahasa_isyarat')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div class="md:col-span-2">
                            <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Pajak & Keuangan</h2>
                        </div>

                        <div>
                            <label class="block font-medium mb-1">NPWP</label>
                            <input type="text" name="npwp" value="{{ old('npwp', $asn->npwp) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                            @error('npwp')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Nama Wajib Pajak</label>
                            <input type="text" name="nama_wajib_pajak" value="{{ old('nama_wajib_pajak', $asn->nama_wajib_pajak) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                            @error('nama_wajib_pajak')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Kewarganegaraan</label>
                            <input type="text" name="kewarganegaraan" value="{{ old('kewarganegaraan', $asn->kewarganegaraan) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                            @error('kewarganegaraan')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Bank</label>
                            <input type="text" name="bank" value="{{ old('bank', $asn->bank) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                            @error('bank')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Nomor Rekening Bank</label>
                            <input type="text" name="nomor_rekening_bank" value="{{ old('nomor_rekening_bank', $asn->nomor_rekening_bank) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                            @error('nomor_rekening_bank')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Rekening Atas Nama</label>
                            <input type="text" name="rekening_atas_nama" value="{{ old('rekening_atas_nama', $asn->rekening_atas_nama) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                            @error('rekening_atas_nama')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div class="md:col-span-2">
                            <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Lainnya</h2>
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Karpeg</label>
                            <input type="text" name="karpeg" value="{{ old('karpeg', $asn->karpeg) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                            @error('karpeg')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Karis/Karsu</label>
                            <input type="text" name="karis_karsu" value="{{ old('karis_karsu', $asn->karis_karsu) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                            @error('karis_karsu')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Lintang</label>
                            <input type="text" name="lintang" value="{{ old('lintang', $asn->lintang) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                            @error('lintang')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Bujur</label>
                            <input type="text" name="bujur" value="{{ old('bujur', $asn->bujur) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                            @error('bujur')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label class="block font-medium mb-1">NUKS</label>
                            <input type="text" name="nuks" value="{{ old('nuks', $asn->nuks) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                            @error('nuks')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="mt-6 flex gap-4">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Update
                        </button>
                        <a href="{{ route('asns.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
