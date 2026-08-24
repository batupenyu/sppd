@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h1 class="text-2xl font-bold mb-6">Edit Form Cuti</h1>

                <form action="{{ route('form-cutis.update', $formCuti) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <h2 class="text-lg font-semibold mb-4 border-b pb-2">Nomor Surat</h2>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block font-medium mb-1">Nomor Surat</label>
                            <input type="text" name="nomor_surat" value="{{ old('nomor_surat', $formCuti->nomor_surat) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>

                        <div class="md:col-span-2">
                            <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">I. Data Pegawai</h2>
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
                                        data-unit-kerja="{{ $asn->unit_kerja ?: '' }}"
                                        {{ old('pegawai_id', $formCuti->pegawai_id) == $asn->id ? 'selected' : '' }}>
                                        {{ $asn->nama }} {{ $asn->nip ? '(' . $asn->nip . ')' : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">II. Jenis Cuti yang Diambil</h2>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block font-medium mb-1">Jenis Cuti</label>
                            <select name="jenis_cuti" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                                <option value="">-- Pilih Jenis Cuti --</option>
                                <option value="Cuti Tahunan" {{ old('jenis_cuti', $formCuti->jenis_cuti) == 'Cuti Tahunan' ? 'selected' : '' }}>1. Cuti Tahunan</option>
                                <option value="Cuti Besar" {{ old('jenis_cuti', $formCuti->jenis_cuti) == 'Cuti Besar' ? 'selected' : '' }}>2. Cuti Besar</option>
                                <option value="Cuti Sakit" {{ old('jenis_cuti', $formCuti->jenis_cuti) == 'Cuti Sakit' ? 'selected' : '' }}>3. Cuti Sakit</option>
                                <option value="Cuti Melahirkan" {{ old('jenis_cuti', $formCuti->jenis_cuti) == 'Cuti Melahirkan' ? 'selected' : '' }}>4. Cuti Melahirkan</option>
                                <option value="Cuti Karena Alasan Penting" {{ old('jenis_cuti', $formCuti->jenis_cuti) == 'Cuti Karena Alasan Penting' ? 'selected' : '' }}>5. Cuti Karena Alasan Penting</option>
                                <option value="Cuti di Luar Tanggungan Negara" {{ old('jenis_cuti', $formCuti->jenis_cuti) == 'Cuti di Luar Tanggungan Negara' ? 'selected' : '' }}>6. Cuti di Luar Tanggungan Negara</option>
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">III. Alasan Cuti</h2>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block font-medium mb-1">Alasan Cuti</label>
                            <textarea name="alasan_cuti" rows="3" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">{{ old('alasan_cuti', $formCuti->alasan_cuti) }}</textarea>
                        </div>

                        <div class="md:col-span-2">
                            <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">IV. Lamanya Cuti</h2>
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Mulai Tanggal</label>
                            <input type="date" name="tanggal_mulai_cuti" value="{{ old('tanggal_mulai_cuti', $formCuti->tanggal_mulai_cuti?->format('Y-m-d')) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Sampai Tanggal</label>
                            <input type="date" name="tanggal_selesai_cuti" value="{{ old('tanggal_selesai_cuti', $formCuti->tanggal_selesai_cuti?->format('Y-m-d')) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>

                        <div class="md:col-span-2">
                            <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">VI. Alamat Selama Menjalankan Cuti</h2>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block font-medium mb-1">Alamat</label>
                            <textarea name="alamat_cuti" rows="2" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">{{ old('alamat_cuti', $formCuti->alamat_cuti) }}</textarea>
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Telepon</label>
                            <input type="text" name="telepon" value="{{ old('telepon', $formCuti->telepon) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>

                        <div class="md:col-span-2">
                            <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">VII. Pertimbangan Atasan Langsung</h2>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block font-medium mb-1">Pilih Kepala Sekolah</label>
                            <select name="kepala_sekolah_id" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                                <option value="">-- Pilih Kepala Sekolah --</option>
                                @foreach($asns as $asn)
                                    <option value="{{ $asn->id }}" {{ old('kepala_sekolah_id', $formCuti->kepala_sekolah_id ?? '') == $asn->id ? 'selected' : '' }}>
                                        {{ $asn->nama }} {{ $asn->nip ? '(' . $asn->nip . ')' : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">VIII. Keputusan Pejabat Yang Berwenang Memberikan Cuti</h2>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block font-medium mb-1">Pilih Kepala Cabang Dinas</label>
                            <select name="kepala_cabang_id" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                                <option value="">-- Pilih Kepala Cabang Dinas --</option>
                                @foreach($asns as $asn)
                                    <option value="{{ $asn->id }}" {{ old('kepala_cabang_id', $formCuti->kepala_cabang_id ?? '') == $asn->id ? 'selected' : '' }}>
                                        {{ $asn->nama }} {{ $asn->nip ? '(' . $asn->nip . ')' : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mt-6 flex gap-4">
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Simpan & Cetak</button>
                        <a href="{{ route('form-cutis.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
