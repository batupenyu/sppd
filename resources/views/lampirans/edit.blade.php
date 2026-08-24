@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h1 class="text-2xl font-bold mb-6">Edit Lampiran</h1>

                @if($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('lampirans.update', $lampiran) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block font-medium mb-1">Judul Lampiran</label>
                            <input type="text" name="judul" value="{{ old('judul', $lampiran->judul) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100" placeholder="Contoh: Lampiran I">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block font-medium mb-1">Nomor</label>
                            <input type="text" name="nomor" value="{{ old('nomor', $lampiran->nomor) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100" placeholder="Contoh: 800.1.11.1/..../SMKN 1 Kb/Dindik/2026">
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Tanggal</label>
                            <input type="date" name="tanggal" value="{{ old('tanggal', $lampiran->tanggal ? $lampiran->tanggal->format('Y-m-d') : '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block font-medium mb-1">Keterangan</label>
                            <textarea name="keterangan" rows="3" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">{{ old('keterangan', $lampiran->keterangan) }}</textarea>
                        </div>

                        <div class="md:col-span-2">
                            <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Peserta</h2>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block font-medium mb-1">Pilih Pegawai</label>
                            <select name="pegawai_ids[]" id="pegawai_select" multiple class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                                @foreach($asns as $asn)
                                    <option value="{{ $asn->id }}" {{ in_array($asn->id, old('pegawai_ids', $lampiran->pegawai_ids ?? [])) ? 'selected' : '' }}>
                                        {{ $asn->nama }} {{ $asn->nip ? '(' . $asn->nip . ')' : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block font-medium mb-1">Pilih Siswa</label>
                            <select name="siswa_ids[]" id="siswa_select" multiple class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                                @foreach($siswas as $siswa)
                                    <option value="{{ $siswa->id }}" {{ in_array($siswa->id, old('siswa_ids', $lampiran->siswa_ids ?? [])) ? 'selected' : '' }}>
                                        {{ $siswa->nama }} {{ $siswa->nis ? '(' . $siswa->nis . ')' : '' }} {{ $siswa->kelas ? '- ' . $siswa->kelas : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Penandatangan</h2>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block font-medium mb-1">Pilih Penandatangan dari Data Pegawai</label>
                            <select id="penandatangan_select" name="penandatangan_id" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                                <option value="">-- Pilih Pegawai --</option>
                                @foreach($asns as $asn)
                                    <option value="{{ $asn->id }}" {{ old('penandatangan_id', $lampiran->penandatangan_id ?? $defaultPenandatanganId) == $asn->id ? 'selected' : '' }}>
                                        {{ $asn->nama }} {{ $asn->nip ? '(' . $asn->nip . ')' : '' }} {{ $asn->jabatan ? '- ' . $asn->jabatan : '' }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="mt-2">
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="penandatangan_an" value="1" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" {{ old('penandatangan_an', $lampiran->penandatangan_an ?? false) ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm text-gray-600">a.n (Atas Nama)</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
                    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
                    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
                    <script>
                        $(function () {
                            $('#pegawai_select').select2({
                                placeholder: '-- Pilih Pegawai --',
                                allowClear: true,
                                width: '100%'
                            });
                            $('#siswa_select').select2({
                                placeholder: '-- Pilih Siswa --',
                                allowClear: true,
                                width: '100%'
                            });
                        });
                    </script>

                    <div class="mt-6 flex gap-4">
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Perbarui</button>
                        <a href="{{ route('lampirans.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
