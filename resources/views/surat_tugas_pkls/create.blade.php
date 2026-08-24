@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h1 class="text-2xl font-bold mb-6">Buat Surat Tugas PKL</h1>

                <form action="{{ route('surat-tugas-pkls.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <h2 class="text-lg font-semibold mb-4 border-b pb-2">Umum</h2>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block font-medium mb-1">Nomor</label>
                            <input type="text" name="nomor" value="{{ old('nomor') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block font-medium mb-1">Dasar (satu item per baris)</label>
                            <textarea name="dasar" rows="4" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">{{ old('dasar') }}</textarea>
                            <p class="text-sm text-gray-500 mt-1">Setiap baris akan menjadi satu poin pada cetakan.</p>
                        </div>

                        <div class="md:col-span-2">
                            <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Peserta (Guru Pendamping & Siswa)</h2>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block font-medium mb-1">Pilih Guru Pendamping (Pegawai)</label>
                            <select name="pegawai_ids[]" id="pegawai_select" multiple class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                                @foreach($asns as $asn)
                                    <option value="{{ $asn->id }}" {{ in_array($asn->id, old('pegawai_ids', [])) ? 'selected' : '' }}>
                                        {{ $asn->nama }} {{ $asn->nip ? '(' . $asn->nip . ')' : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block font-medium mb-1">Pilih Siswa</label>
                            <select name="siswa_ids[]" id="siswa_select" multiple class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                                @foreach($siswas as $siswa)
                                    <option value="{{ $siswa->id }}" {{ in_array($siswa->id, old('siswa_ids', [])) ? 'selected' : '' }}>
                                        {{ $siswa->nama }} {{ $siswa->nis ? '(' . $siswa->nis . ')' : '' }} {{ $siswa->kelas ? '- ' . $siswa->kelas : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Untuk</h2>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block font-medium mb-1">Kegiatan</label>
                            <textarea name="kegiatan" rows="2" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">{{ old('kegiatan') }}</textarea>
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Pukul</label>
                            <input type="text" name="pukul" value="{{ old('pukul', '09:00 WIB s.d Selesai') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100" placeholder="contoh: 08.00 WIB">
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Tempat</label>
                            <input type="text" name="tempat" value="{{ old('tempat') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Sumber Dana</label>
                            <select name="sumber_dana" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                                <option value="">-- Pilih Sumber Dana --</option>
                                <option value="dana APBD" {{ old('sumber_dana') == 'dana APBD' ? 'selected' : '' }}>dana APBD</option>
                                <option value="dana APBN" {{ old('sumber_dana') == 'dana APBN' ? 'selected' : '' }}>dana APBN</option>
                            </select>
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Tahun Anggaran</label>
                            <input type="text" name="tahun_anggaran" value="{{ old('tahun_anggaran', date('Y')) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>

                        <div class="md:col-span-2">
                            <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Penandatangan</h2>
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Dikeluarkan di</label>
                            <input type="text" name="dikeluarkan_di" value="{{ old('dikeluarkan_di') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Tanggal Dikeluarkan</label>
                            <input type="date" name="tanggal_dikeluarkan" value="{{ old('tanggal_dikeluarkan') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block font-medium mb-1">Pilih Penandatangan dari Data Pegawai</label>
                            <select id="penandatangan_select" name="penandatangan_id" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                                <option value="">-- Pilih Pegawai --</option>
                                @foreach($asns as $asn)
                                    <option value="{{ $asn->id }}"
                                        data-nama="{{ $asn->nama }}"
                                        data-jabatan="{{ $asn->tugas_tambahan ?: ($asn->jenis_ptk ?: ($asn->pangkat_golongan ?: '')) }}"
                                        data-nip="{{ $asn->nip ?: '' }}"
                                        {{ old('penandatangan_id', $defaultPenandatanganId) == $asn->id ? 'selected' : '' }}>
                                        {{ $asn->nama }} {{ $asn->nip ? '(' . $asn->nip . ')' : '' }} {{ $asn->tugas_tambahan ? '- ' . $asn->tugas_tambahan : '' }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="mt-2">
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="penandatangan_plt" value="1" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" {{ old('penandatangan_plt') ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm text-gray-600">Plt (Pelaksana Tugas)</span>
                                </label>
                                <label class="inline-flex items-center ml-4">
                                    <input type="checkbox" name="penandatangan_an" value="1" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" {{ old('penandatangan_an') ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm text-gray-600">a.n (Atas Nama)</span>
                                </label>
                            </div>
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Nama Penandatangan</label>
                            <input type="text" name="nama_penandatangan" id="nama_penandatangan" value="{{ old('nama_penandatangan') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>
                    </div>

                    <input type="hidden" name="nip_penandatangan" id="nip_penandatangan" value="{{ old('nip_penandatangan') }}">

                    <script>
                        function isiPenandatangan() {
                            const select = document.getElementById('penandatangan_select');
                            const opt = select.options[select.selectedIndex];
                            document.getElementById('nama_penandatangan').value = opt.dataset.nama || '';
                            document.getElementById('nip_penandatangan').value = opt.dataset.nip || '';
                        }
                        document.getElementById('penandatangan_select').addEventListener('change', isiPenandatangan);
                        isiPenandatangan();
                    </script>

                    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
                    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
                    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
                    <script>
                        $(function () {
                            $('#pegawai_select').select2({
                                placeholder: '-- Pilih Guru Pendamping --',
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
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Simpan</button>
                        <a href="{{ route('surat-tugas-pkls.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
