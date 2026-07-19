@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h1 class="text-2xl font-bold mb-6">Edit Laporan Nota Dinas</h1>

                <form action="{{ route('laporan-nodins.update', $laporanNodin) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <h2 class="text-lg font-semibold mb-4 border-b pb-2">Kepala Surat</h2>
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Kepada</label>
                            <input type="text" name="kepada" value="{{ old('kepada', $laporanNodin->kepada) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Dari</label>
                            <input type="text" name="dari" value="{{ old('dari', $laporanNodin->dari) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Nomor</label>
                            <input type="text" name="nomor" value="{{ old('nomor', $laporanNodin->nomor) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Lampiran</label>
                            <input type="text" name="lampiran" value="{{ old('lampiran', $laporanNodin->lampiran) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Tanggal</label>
                            <input type="date" name="tanggal" value="{{ old('tanggal', $laporanNodin->tanggal) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Perihal</label>
                            <input type="text" name="perihal" value="{{ old('perihal', $laporanNodin->perihal) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>

                        <div class="md:col-span-2">
                            <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Dasar & Tujuan</h2>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block font-medium mb-1">Dasar Pelaksanaan</label>
                            <textarea name="dasar_pelaksanaan" rows="3" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">{{ old('dasar_pelaksanaan', $laporanNodin->dasar_pelaksanaan) }}</textarea>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block font-medium mb-1">Tujuan</label>
                            <textarea name="tujuan" rows="3" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">{{ old('tujuan', $laporanNodin->tujuan) }}</textarea>
                        </div>

                        <div class="md:col-span-2">
                            <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Peserta 1</h2>
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Nama</label>
                            <input type="text" name="peserta1_nama" value="{{ old('peserta1_nama', $laporanNodin->peserta1_nama) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>
                        <div>
                            <label class="block font-medium mb-1">NIP</label>
                            <input type="text" name="peserta1_nip" value="{{ old('peserta1_nip', $laporanNodin->peserta1_nip) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block font-medium mb-1">Jabatan</label>
                            <input type="text" name="peserta1_jabatan" value="{{ old('peserta1_jabatan', $laporanNodin->peserta1_jabatan) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>

                        <div class="md:col-span-2">
                            <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Peserta 2</h2>
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Nama</label>
                            <input type="text" name="peserta2_nama" value="{{ old('peserta2_nama', $laporanNodin->peserta2_nama) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>
                        <div>
                            <label class="block font-medium mb-1">NIP</label>
                            <input type="text" name="peserta2_nip" value="{{ old('peserta2_nip', $laporanNodin->peserta2_nip) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block font-medium mb-1">Jabatan</label>
                            <input type="text" name="peserta2_jabatan" value="{{ old('peserta2_jabatan', $laporanNodin->peserta2_jabatan) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>

                        <div class="md:col-span-2">
                            <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Pelaksanaan</h2>
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Tanggal</label>
                            <input type="date" name="pelaksanaan_tanggal" value="{{ old('pelaksanaan_tanggal', $laporanNodin->pelaksanaan_tanggal) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Jam</label>
                            <input type="text" name="pelaksanaan_jam" value="{{ old('pelaksanaan_jam', $laporanNodin->pelaksanaan_jam) }}" placeholder="07:30" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block font-medium mb-1">Tempat</label>
                            <input type="text" name="pelaksanaan_tempat" value="{{ old('pelaksanaan_tempat', $laporanNodin->pelaksanaan_tempat) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block font-medium mb-1">Kesimpulan</label>
                            <textarea name="kesimpulan" rows="4" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">{{ old('kesimpulan', $laporanNodin->kesimpulan) }}</textarea>
                        </div>

                        <div class="md:col-span-2">
                            <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Penandatangan & Kop Surat</h2>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block font-medium mb-1">Pilih Penandatangan</label>
                            <select id="penandatangan_select" name="penandatangan_id" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                                <option value="">-- Pilih Penandatangan --</option>
                                @foreach($asns as $asn)
                                    <option value="{{ $asn->id }}"
                                        data-nama="{{ $asn->nama }}"
                                        data-nip="{{ $asn->nip ?: '' }}"
                                        data-pangkat="{{ $asn->pangkat_golongan ?: '' }}"
                                        data-jabatan="{{ $asn->tugas_tambahan ?: ($asn->jenis_ptk ?: ($asn->pangkat_golongan ?: '')) }}"
                                        {{ old('penandatangan_id', $laporanNodin->penandatangan_id) == $asn->id ? 'selected' : '' }}>
                                        {{ $asn->nama }} {{ $asn->nip ? '(' . $asn->nip . ')' : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block font-medium mb-1">Kop Surat</label>
                            <select name="kop_surat" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                                <option value="">-- Default (kop_smk) --</option>
                                @foreach($logos as $logo)
                                    <option value="{{ $logo->name }}" {{ old('kop_surat', $laporanNodin->kop_surat) == $logo->name ? 'selected' : '' }}>
                                        {{ $logo->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mt-6 flex gap-4">
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Simpan & Cetak</button>
                        <a href="{{ route('laporan-nodins.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
