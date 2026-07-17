@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h1 class="text-2xl font-bold mb-6">Edit SPD Pegawai</h1>

                <form action="{{ route('spds.update', $spd) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <h2 class="text-lg font-semibold mb-4 border-b pb-2">Data Umum</h2>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block font-medium mb-1">Pegawai (ASN) *</label>
                            <select name="asn_id" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100" required>
                                <option value="">-- Pilih Pegawai --</option>
                                @foreach($asns as $asn)
                                    <option value="{{ $asn->id }}"
                                        {{ (old('asn_id', $spd->asn_id) == $asn->id) ? 'selected' : '' }}>
                                        {{ $asn->nama }} {{ $asn->nip ? '(' . $asn->nip . ')' : '' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('asn_id')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Nomor</label>
                            <input type="text" name="nomor" value="{{ old('nomor', $spd->nomor) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Lembar Ke</label>
                            <input type="text" name="lembar_ke" value="{{ old('lembar_ke', $spd->lembar_ke) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Kode No.</label>
                            <input type="text" name="kode_no" value="{{ old('kode_no', $spd->kode_no) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>

                        <div class="md:col-span-2">
                            <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Pejabat & Pegawai</h2>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block font-medium mb-1">PA/KPA/PPK/Pejabat Berwenang *</label>
                            <select name="pejabat_pemberi_tugas" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100" required>
                                <option value="">-- Pilih Pejabat --</option>
                                @foreach($asns as $asn)
                                    <option value="{{ $asn->nama }}" {{ (old('pejabat_pemberi_tugas', $spd->pejabat_pemberi_tugas) == $asn->nama) ? 'selected' : '' }}>
                                        {{ $asn->nama }} {{ $asn->nip ? '(' . $asn->nip . ')' : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Nama Pegawai *</label>
                            <input type="text" name="nama" value="{{ old('nama', $spd->nama) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100" required>
                        </div>
                        <div>
                            <label class="block font-medium mb-1">NIP</label>
                            <input type="text" name="nip" value="{{ old('nip', $spd->nip) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Pangkat dan Golongan</label>
                            <input type="text" name="pangkat_golongan" value="{{ old('pangkat_golongan', $spd->pangkat_golongan) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Jabatan/Instansi</label>
                            <input type="text" name="jabatan_instansi" value="{{ old('jabatan_instansi', $spd->jabatan_instansi) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Tingkat Biaya Perjalanan Dinas</label>
                            <input type="text" name="tingkat_biaya" value="{{ old('tingkat_biaya', $spd->tingkat_biaya) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>

                        <div class="md:col-span-2">
                            <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Perjalanan Dinas</h2>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block font-medium mb-1">Maksud Perjalanan Dinas *</label>
                            <textarea name="maksud_perjalanan" rows="2" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100" required>{{ old('maksud_perjalanan', $spd->maksud_perjalanan) }}</textarea>
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Alat Angkut</label>
                            <input type="text" name="alat_angkut" value="{{ old('alat_angkut', $spd->alat_angkut) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Lama Perjalanan (hari)</label>
                            <input type="number" name="lama_perjalanan" min="0" value="{{ old('lama_perjalanan', $spd->lama_perjalanan) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Tempat Berangkat *</label>
                            <input type="text" name="tempat_berangkat" value="{{ old('tempat_berangkat', $spd->tempat_berangkat) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100" required>
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Tempat Tujuan *</label>
                            <input type="text" name="tempat_tujuan" value="{{ old('tempat_tujuan', $spd->tempat_tujuan) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100" required>
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Tanggal Berangkat</label>
                            <input type="date" name="tanggal_berangkat" value="{{ old('tanggal_berangkat', optional($spd->tanggal_berangkat)->format('Y-m-d')) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Tanggal Harus Kembali</label>
                            <input type="date" name="tanggal_kembali" value="{{ old('tanggal_kembali', optional($spd->tanggal_kembali)->format('Y-m-d')) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>

                        <div class="md:col-span-2">
                            <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Lainnya</h2>
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Instansi</label>
                            <input type="text" name="instansi" value="{{ old('instansi', $spd->instansi) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Akun</label>
                            <input type="text" name="akun" value="{{ old('akun', $spd->akun) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block font-medium mb-1">Keterangan Lain-lain</label>
                            <textarea name="keterangan_lain" rows="2" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">{{ old('keterangan_lain', $spd->keterangan_lain) }}</textarea>
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Dikeluarkan di</label>
                            <input type="text" name="dikeluarkan_di" value="{{ old('dikeluarkan_di', $spd->dikeluarkan_di) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Tanggal Dikeluarkan</label>
                            <input type="date" name="tanggal_dikeluarkan" value="{{ old('tanggal_dikeluarkan', optional($spd->tanggal_dikeluarkan)->format('Y-m-d')) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>
                    </div>

                    <div class="mt-6 flex gap-4">
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Simpan</button>
                        <a href="{{ route('spds.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
