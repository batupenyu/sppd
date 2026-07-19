@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h1 class="text-2xl font-bold mb-6">Surat Pertanggungjawaban Mutlak (SPTJM)</h1>

                <form action="{{ route('sptjms.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block font-medium mb-1">Nomor Surat</label>
                            <input type="text" name="nomor_surat" value="{{ old('nomor_surat') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Tempat Ditetapkan</label>
                            <input type="text" name="tempat_ditetapkan" value="{{ old('tempat_ditetapkan') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Tanggal Ditetapkan</label>
                            <input type="date" name="tanggal_ditetapkan" value="{{ old('tanggal_ditetapkan') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block font-medium mb-1">Pegawai (bisa lebih dari satu)</label>
                            <select name="pegawai[]" multiple size="8" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                                @foreach($asns as $asn)
                                    <option value="{{ $asn->id }}" {{ in_array($asn->id, old('pegawai', [])) ? 'selected' : '' }}>
                                        {{ $asn->nama }} {{ $asn->nip ? '(' . $asn->nip . ')' : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block font-medium mb-1">Pilih Penandatangan dari Data Pegawai</label>
                            <select id="penandatangan_select" name="penandatangan_id" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                                <option value="">-- Pilih Pegawai --</option>
                                @foreach($asns as $asn)
                                    <option value="{{ $asn->id }}"
                                        data-nama="{{ $asn->nama }}"
                                        data-nip="{{ $asn->nip ?: '' }}"
                                        data-jabatan="{{ $asn->tugas_tambahan ?: ($asn->jenis_ptk ?: ($asn->pangkat_golongan ?: '')) }}"
                                        data-pangkat="{{ $asn->pangkat_golongan ?: '' }}"
                                        {{ old('penandatangan_id', $defaultPenandatanganId) == $asn->id ? 'selected' : '' }}>
                                        {{ $asn->nama }} {{ $asn->nip ? '(' . $asn->nip . ')' : '' }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-sm text-gray-500 mt-1">Data penandatangan diambil otomatis dari pegawai terpilih.</p>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block font-medium mb-1">Isi Surat</label>
                            <textarea name="isi_surat" rows="5" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">{{ old('isi_surat') }}</textarea>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block font-medium mb-1">Penutup Surat</label>
                            <textarea name="penutup_surat" rows="3" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">{{ old('penutup_surat') }}</textarea>
                        </div>
                    </div>

                    <div class="mt-6 flex gap-4">
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Simpan & Cetak</button>
                        <a href="{{ route('sptjms.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('penandatangan_select').addEventListener('change', function () {
        const opt = this.options[this.selectedIndex];
        window.__penandatangan = {
            nama: opt.dataset.nama || '',
            nip: opt.dataset.nip || '',
            jabatan: opt.dataset.jabatan || '',
            pangkat: opt.dataset.pangkat || '',
        };
    });
</script>
@endsection
