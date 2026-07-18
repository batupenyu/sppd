@php($kp4 = $suratKp4 ?? null)
@php($anggota = old('anggota', $kp4 && $kp4->anggotaKeluarga ? $kp4->anggotaKeluarga->toArray() : []))

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="md:col-span-2">
        <h2 class="text-lg font-semibold mb-4 border-b pb-2">Data Surat</h2>
    </div>

    <div>
        <label class="block font-medium mb-1">Nomor Surat</label>
        <input type="text" name="nomor_surat" value="{{ old('nomor_surat', $kp4->nomor_surat ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>

    <div>
        <label class="block font-medium mb-1">Tempat Ditetapkan</label>
        <input type="text" name="tempat_ditetapkan" value="{{ old('tempat_ditetapkan', $kp4->tempat_ditetapkan ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>

    <div>
        <label class="block font-medium mb-1">Tanggal Ditetapkan</label>
        <input type="date" name="tanggal_ditetapkan" value="{{ old('tanggal_ditetapkan', optional($kp4->tanggal_ditetapkan ?? null)->format('Y-m-d')) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>

    <div>
        <label class="block font-medium mb-1">Status Kepegawaian</label>
        <input type="text" name="status_kepegawaian" value="{{ old('status_kepegawaian', $kp4->status_kepegawaian ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>

    <div>
        <label class="block font-medium mb-1">Masa Kerja Golongan</label>
        <input type="text" name="masa_kerja_golongan" value="{{ old('masa_kerja_golongan', $kp4->masa_kerja_golongan ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>

    <div>
        <label class="block font-medium mb-1">Digaji Menurut</label>
        <input type="text" name="digaji_menurut" value="{{ old('digaji_menurut', $kp4->digaji_menurut ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>

    <div class="md:col-span-2">
        <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Pegawai & Penandatangan</h2>
    </div>

    <div>
        <label class="block font-medium mb-1">Pilih Pegawai (ASN)</label>
        <select name="pegawai_id" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
            <option value="">-- Pilih Pegawai --</option>
            @foreach($asns as $asn)
                <option value="{{ $asn->id }}" {{ old('pegawai_id', $kp4->pegawai_id ?? '') == $asn->id ? 'selected' : '' }}>
                    {{ $asn->nama }} {{ $asn->nip ? '(' . $asn->nip . ')' : '' }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block font-medium mb-1">Pilih Penandatangan</label>
        <select name="penandatangan_id" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
            <option value="">-- Pilih Penandatangan --</option>
            @foreach($asns as $asn)
                <option value="{{ $asn->id }}" {{ old('penandatangan_id', $kp4->penandatangan_id ?? '') == $asn->id ? 'selected' : '' }}>
                    {{ $asn->nama }} {{ $asn->nip ? '(' . $asn->nip . ')' : '' }}
                </option>
            @endforeach
        </select>
    </div>
</div>

<div class="mt-8">
    <div class="flex justify-between items-center mb-2">
        <h2 class="text-lg font-semibold border-b pb-2">Susunan Keluarga</h2>
        <button type="button" id="tambah-anggota" class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-bold py-1 px-3 rounded">+ Tambah Anggota</button>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full table-auto border" id="tabel-anggota">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-2 py-2 text-left">Nama Istri / Suami / Tanggungan</th>
                    <th class="px-2 py-2 text-left">Tgl Kelahiran</th>
                    <th class="px-2 py-2 text-left">Tgl Perkawinan</th>
                    <th class="px-2 py-2 text-left">Pekerjaan</th>
                    <th class="px-2 py-2 text-left">Keterangan</th>
                    <th class="px-2 py-2 text-left">Mendapat Tunjangan</th>
                    <th class="px-2 py-2 text-left"></th>
                </tr>
            </thead>
            <tbody class="anggota-list">
                @forelse($anggota as $index => $a)
                    @include('surat_kp4s._anggota_row', ['a' => $a, 'i' => $index])
                @empty
                    @include('surat_kp4s._anggota_row', ['a' => null, 'i' => 0])
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<template id="anggota-template">
    @include('surat_kp4s._anggota_row', ['a' => null, 'i' => '__INDEX__'])
</template>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const list = document.querySelector('.anggota-list');
    const template = document.getElementById('anggota-template');
    const btnTambah = document.getElementById('tambah-anggota');

    function nextIndex() {
        return list.querySelectorAll('tr.anggota-row').length;
    }

    btnTambah.addEventListener('click', function () {
        let html = template.innerHTML.replaceAll('__INDEX__', nextIndex());
        list.insertAdjacentHTML('beforeend', html);
    });

    list.addEventListener('click', function (e) {
        if (e.target.closest('.hapus-anggota')) {
            e.target.closest('tr.anggota-row').remove();
        }
    });
});
</script>
