@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h1 class="text-2xl font-bold mb-6">Buat Surat Tugas</h1>

                <form action="{{ route('surat-tugas.store') }}" method="POST">
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
                            <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Peserta (Pegawai yang Diperintahkan)</h2>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block font-medium mb-1">Pilih Pegawai (bisa lebih dari satu)</label>
                            <select name="peserta[]" id="peserta_select" multiple class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100" required>
                                @foreach($asns as $asn)
                                    <option value="{{ $asn->id }}" {{ in_array($asn->id, old('peserta', [])) ? 'selected' : '' }}>
                                        {{ $asn->nama }} {{ $asn->nip ? '(' . $asn->nip . ')' : '' }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-sm text-gray-500 mt-1">Nama, NIP, Pangkat, dan Jabatan akan otomatis tampil di cetakan.</p>
                        </div>

                        <div class="md:col-span-2">
                            <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Untuk</h2>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block font-medium mb-1">Untuk 1</label>
                            <textarea name="untuk_1" rows="2" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">{{ old('untuk_1') }}</textarea>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block font-medium mb-1">Untuk 2</label>
                            <textarea name="untuk_2" rows="2" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">{{ old('untuk_2') }}</textarea>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block font-medium mb-1">Untuk 3</label>
                            <textarea name="untuk_3" rows="2" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">{{ old('untuk_3') }}</textarea>
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
                                        {{ old('penandatangan_id') == $asn->id ? 'selected' : '' }}>
                                        {{ $asn->nama }} {{ $asn->nip ? '(' . $asn->nip . ')' : '' }} {{ $asn->tugas_tambahan ? '- ' . $asn->tugas_tambahan : '' }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-sm text-gray-500 mt-1">Pilih pegawai, lalu nama & jabatan akan terisi otomatis (masih bisa diedit).</p>
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Jabatan Penandatangan</label>
                            <input type="text" name="jabatan_penandatangan" id="jabatan_penandatangan" value="{{ old('jabatan_penandatangan') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
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
                            document.getElementById('jabatan_penandatangan').value = opt.dataset.jabatan || '';
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
                            $('#peserta_select').select2({
                                placeholder: '-- Pilih Pegawai --',
                                allowClear: true,
                                width: '100%'
                            });
                        });
                    </script>

                    <div class="mt-6 flex gap-4">
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Simpan</button>
                        <a href="{{ route('surat-tugas.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
