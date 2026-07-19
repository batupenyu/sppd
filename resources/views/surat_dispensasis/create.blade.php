@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h1 class="text-2xl font-bold mb-6">Buat Surat Dispensasi</h1>

                <form action="{{ route('surat-dispensasis.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <h2 class="text-lg font-semibold mb-4 border-b pb-2">Data Umum</h2>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block font-medium mb-1">Nomor Surat</label>
                            <input type="text" name="nomor_surat" value="{{ old('nomor_surat') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>

                        <div class="md:col-span-2">
                            <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Kegiatan</h2>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block font-medium mb-1">Nama Kegiatan</label>
                            <input type="text" name="nama_kegiatan" value="{{ old('nama_kegiatan') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Hari/Tanggal</label>
                            <input type="text" name="hari_tanggal" value="{{ old('hari_tanggal') }}" placeholder="Contoh: Senin, 20 Juli 2026" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Waktu</label>
                            <input type="text" name="waktu" value="{{ old('waktu') }}" placeholder="Contoh: 08:00 - 12:00" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block font-medium mb-1">Tempat</label>
                            <input type="text" name="tempat" value="{{ old('tempat') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>

                        <div class="md:col-span-2">
                            <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Peserta Dispensasi</h2>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block font-medium mb-1">Pilih Peserta (Siswa / ASN)</label>
                            <select name="peserta_select[]" multiple id="peserta_select" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                                <optgroup label="Siswa">
                                    @foreach($siswas as $siswa)
                                        <option value="siswa_{{ $siswa->id }}" {{ in_array('siswa_' . $siswa->id, old('peserta_select', [])) ? 'selected' : '' }}>
                                            {{ $siswa->nama }} {{ $siswa->kelas ? '(' . $siswa->kelas . ')' : '' }}
                                        </option>
                                    @endforeach
                                </optgroup>
                                <optgroup label="ASN / Pegawai">
                                    @foreach($asns as $asn)
                                        <option value="asn_{{ $asn->id }}" {{ in_array('asn_' . $asn->id, old('peserta_select', [])) ? 'selected' : '' }}>
                                            {{ $asn->nama }} {{ $asn->nip ? '(' . $asn->nip . ')' : '' }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Penandatangan</h2>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block font-medium mb-1">Pilih Penandatangan</label>
                            <select id="penandatangan_select" name="penandatangan_id" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                                <option value="">-- Pilih Penandatangan --</option>
                                @foreach($asns as $asn)
                                    <option value="{{ $asn->id }}"
                                        data-nama="{{ $asn->nama }}"
                                        data-nip="{{ $asn->nip ?: '' }}"
                                        data-pangkat="{{ $asn->pangkat ?? '' }}"
                                        data-golongan="{{ $asn->golongan ?? '' }}"
                                        data-jabatan="{{ $asn->tugas_tambahan ?? ($asn->jenis_ptk ?? '') }}"
                                        {{ old('penandatangan_id') == $asn->id ? 'selected' : '' }}>
                                        {{ $asn->nama }} {{ $asn->nip ? '(' . $asn->nip . ')' : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Surat</h2>
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Tempat Ditetapkan</label>
                            <input type="text" name="tempat_ditetapkan" value="{{ old('tempat_ditetapkan') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Tanggal Ditetapkan</label>
                            <input type="date" name="tanggal_ditetapkan" value="{{ old('tanggal_ditetapkan') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>
                    </div>

                    <div class="mt-6 flex gap-4">
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Simpan & Cetak</button>
                        <a href="{{ route('surat-dispensasis.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    $('#peserta_select').select2({
        placeholder: 'Pilih peserta...',
        allowClear: true,
        closeOnSelect: false,
    });
});
</script>
@endsection
