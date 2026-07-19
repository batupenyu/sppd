@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h1 class="text-2xl font-bold mb-6">Buat Laporan Cuti</h1>

                <form action="{{ route('laporan-cutis.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <h2 class="text-lg font-semibold mb-4 border-b pb-2">Data Pegawai</h2>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block font-medium mb-1">Pilih ASN</label>
                            <select id="asn_select" name="asn_id" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                                <option value="">-- Pilih ASN --</option>
                                @foreach($asns as $asn)
                                    <option value="{{ $asn->id }}"
                                        data-nama="{{ $asn->nama }}"
                                        data-nip="{{ $asn->nip ?: '' }}"
                                        data-pangkat="{{ $asn->pangkat_golongan ?: '' }}"
                                        data-jabatan="{{ $asn->tugas_tambahan ?: ($asn->jenis_ptk ?: ($asn->pangkat_golongan ?: '')) }}"
                                        {{ old('asn_id') == $asn->id ? 'selected' : '' }}>
                                        {{ $asn->nama }} {{ $asn->nip ? '(' . $asn->nip . ')' : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Periode</h2>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block font-medium mb-1">Tahun</label>
                            <input type="text" name="tahun" value="{{ old('tahun') }}" placeholder="Contoh: 2024 atau 2023 - 2024" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>

                        <div class="md:col-span-2">
                            <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Alokasi Cuti</h2>
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Alokasi Awal Tahun N</label>
                            <input type="number" name="alokasi_awal_tahun_n" value="{{ old('alokasi_awal_tahun_n') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Alokasi Awal Tahun N-1</label>
                            <input type="number" name="alokasi_awal_tahun_n_1" value="{{ old('alokasi_awal_tahun_n_1') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Alokasi Awal Tahun N-2</label>
                            <input type="number" name="alokasi_awal_tahun_n_2" value="{{ old('alokasi_awal_tahun_n_2') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Total Alokasi Awal</label>
                            <input type="number" id="total_alokasi_awal" name="total_alokasi_awal" value="{{ old('total_alokasi_awal') }}" readonly class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
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
                                        {{ old('penandatangan_id', $defaultPenandatanganId) == $asn->id ? 'selected' : '' }}>
                                        {{ $asn->nama }} {{ $asn->nip ? '(' . $asn->nip . ')' : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mt-6 flex gap-4">
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Simpan & Cetak</button>
                        <a href="{{ route('laporan-cutis.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Batal</a>
                    </div>
                </form>

                <script>
                    (function() {
                        const nInput = document.querySelector('input[name="alokasi_awal_tahun_n"]');
                        const n1Input = document.querySelector('input[name="alokasi_awal_tahun_n_1"]');
                        const n2Input = document.querySelector('input[name="alokasi_awal_tahun_n_2"]');
                        const totalInput = document.getElementById('total_alokasi_awal');

                        function updateTotal() {
                            const n = parseInt(nInput.value || '0', 10);
                            const n1 = parseInt(n1Input.value || '0', 10);
                            const n2 = parseInt(n2Input.value || '0', 10);
                            totalInput.value = n + n1 + n2;
                        }

                        [nInput, n1Input, n2Input].forEach(function(el) {
                            el.addEventListener('input', updateTotal);
                        });

                        updateTotal();
                    })();
                </script>
            </div>
        </div>
    </div>
</div>
@endsection
