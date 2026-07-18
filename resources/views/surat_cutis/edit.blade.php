@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h1 class="text-2xl font-bold mb-6">Edit Surat Cuti</h1>

                <form action="{{ route('surat-cutis.update', $suratCuti) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <h2 class="text-lg font-semibold mb-4 border-b pb-2">Data Umum</h2>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block font-medium mb-1">Nomor Surat</label>
                            <input type="text" name="nomor_surat" value="{{ old('nomor_surat', $suratCuti->nomor_surat) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Sifat Surat</label>
                            <input type="text" name="sifat_surat" value="{{ old('sifat_surat', $suratCuti->sifat_surat) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Lampiran Surat</label>
                            <input type="text" name="lampiran_surat" value="{{ old('lampiran_surat', $suratCuti->lampiran_surat) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block font-medium mb-1">Perihal Surat</label>
                            <input type="text" name="perihal_surat" value="{{ old('perihal_surat', $suratCuti->perihal_surat) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Jenis Cuti</label>
                            <input type="text" name="jenis_cuti" value="{{ old('jenis_cuti', $suratCuti->jenis_cuti) }}" placeholder="Contoh: Cuti Tahunan" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Tujuan Surat</label>
                            <input type="text" name="tujuan_surat" value="{{ old('tujuan_surat', $suratCuti->tujuan_surat) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>

                        <div class="md:col-span-2">
                            <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Waktu Cuti</h2>
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Tanggal Mulai Cuti</label>
                            <input type="date" name="tanggal_mulai_cuti" value="{{ old('tanggal_mulai_cuti', $suratCuti->tanggal_mulai_cuti) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Tanggal Selesai Cuti</label>
                            <input type="date" name="tanggal_selesai_cuti" value="{{ old('tanggal_selesai_cuti', $suratCuti->tanggal_selesai_cuti) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block font-medium mb-1">Alasan Cuti</label>
                            <textarea name="alasan_cuti" rows="3" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">{{ old('alasan_cuti', $suratCuti->alasan_cuti) }}</textarea>
                        </div>

                        <div class="md:col-span-2">
                            <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Pegawai</h2>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block font-medium mb-1">Pilih Pegawai</label>
                            <select id="pegawai_select" name="pegawai_id" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                                <option value="">-- Pilih Pegawai --</option>
                                @foreach($asns as $asn)
                                    <option value="{{ $asn->id }}"
                                        data-nama="{{ $asn->nama }}"
                                        data-nip="{{ $asn->nip ?: '' }}"
                                        data-pangkat="{{ $asn->pangkat_golongan ?: '' }}"
                                        data-jabatan="{{ $asn->tugas_tambahan ?: ($asn->jenis_ptk ?: ($asn->pangkat_golongan ?: '')) }}"
                                        {{ old('pegawai_id', $suratCuti->pegawai_id) == $asn->id ? 'selected' : '' }}>
                                        {{ $asn->nama }} {{ $asn->nip ? '(' . $asn->nip . ')' : '' }}
                                    </option>
                                @endforeach
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
                                        data-pangkat="{{ $asn->pangkat_golongan ?: '' }}"
                                        data-jabatan="{{ $asn->tugas_tambahan ?: ($asn->jenis_ptk ?: ($asn->pangkat_golongan ?: '')) }}"
                                        {{ old('penandatangan_id', $suratCuti->penandatangan_id) == $asn->id ? 'selected' : '' }}>
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
                            <input type="text" name="tempat_ditetapkan" value="{{ old('tempat_ditetapkan', $suratCuti->tempat_ditetapkan) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Tanggal Surat</label>
                            <input type="date" name="tanggal_surat" value="{{ old('tanggal_surat', $suratCuti->tanggal_surat) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>
                    </div>

                    <div class="mt-6 flex gap-4">
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Simpan & Cetak</button>
                        <a href="{{ route('surat-cutis.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
