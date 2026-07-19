@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h1 class="text-2xl font-bold mb-6">Buat Laporan Nota Dinas</h1>

                <form action="{{ route('laporan-nodins.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <h2 class="text-lg font-semibold mb-4 border-b pb-2">Kepala Surat</h2>
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Kepada</label>
                            <input type="text" name="kepada" value="{{ old('kepada') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Dari</label>
                            <input type="text" name="dari" value="{{ old('dari') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Nomor</label>
                            <input type="text" name="nomor" value="{{ old('nomor') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Lampiran</label>
                            <input type="text" name="lampiran" value="{{ old('lampiran') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Tanggal</label>
                            <input type="date" name="tanggal" value="{{ old('tanggal') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Perihal</label>
                            <input type="text" name="perihal" value="{{ old('perihal') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>

                        <div class="md:col-span-2">
                            <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Dasar & Tujuan</h2>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block font-medium mb-1">Dasar Pelaksanaan</label>
                            <textarea name="dasar_pelaksanaan" rows="3" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100 text-justify">{{ old('dasar_pelaksanaan') }}</textarea>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block font-medium mb-1">Tujuan</label>
                            <textarea name="tujuan" rows="3" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100 text-justify">{{ old('tujuan') }}</textarea>
                        </div>

                        <div class="md:col-span-2">
                            <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Peserta (bisa lebih dari satu)</h2>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block font-medium mb-1">Pilih Pegawai</label>
                            <select name="peserta[]" id="peserta_select" multiple class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                                @foreach($asns as $asn)
                                    <option value="{{ $asn->id }}" {{ in_array($asn->id, old('peserta', [])) ? 'selected' : '' }}>
                                        {{ $asn->nama }} {{ $asn->nip ? '(' . $asn->nip . ')' : '' }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-sm text-gray-500 mt-1">Nama, NIP, dan Jabatan akan otomatis tampil di cetakan.</p>
                        </div>

                        <div class="md:col-span-2">
                            <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Pelaksanaan</h2>
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Tanggal</label>
                            <input type="date" name="pelaksanaan_tanggal" value="{{ old('pelaksanaan_tanggal') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Jam</label>
                            <input type="text" name="pelaksanaan_jam" value="{{ old('pelaksanaan_jam') }}" placeholder="07:30" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block font-medium mb-1">Tempat</label>
                            <input type="text" name="pelaksanaan_tempat" value="{{ old('pelaksanaan_tempat') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block font-medium mb-1">Kesimpulan</label>
                            <textarea name="kesimpulan" rows="4" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100 text-justify">{{ old('kesimpulan') }}</textarea>
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
                                        {{ old('penandatangan_id', $defaultPenandatanganId) == $asn->id ? 'selected' : '' }}>
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
                                    <option value="{{ $logo->name }}" {{ old('kop_surat') == $logo->name ? 'selected' : '' }}>
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

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(function () {
        $('#peserta_select').select2({
            placeholder: '-- Pilih Pegawai --',
            allowClear: true,
            width: '100%'
        });
    });
</script>
@endsection
