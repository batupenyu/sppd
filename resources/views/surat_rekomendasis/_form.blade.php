@php($sr = $suratRekomendasi ?? null)

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="md:col-span-2">
        <h2 class="text-lg font-semibold mb-4 border-b pb-2">Data Surat</h2>
    </div>

    <div class="md:col-span-2">
        <label class="block font-medium mb-1">Nomor Surat</label>
        <input type="text" name="nomor_surat" value="{{ old('nomor_surat', $sr->nomor_surat ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>

    <div>
        <label class="block font-medium mb-1">Instansi</label>
        <input type="text" name="instansi" value="{{ old('instansi', $sr->instansi ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>
    <div>
        <label class="block font-medium mb-1">Tempat Ditetapkan</label>
        <input type="text" name="tempat_ditetapkan" value="{{ old('tempat_ditetapkan', $sr->tempat_ditetapkan ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>

    <div class="md:col-span-2">
        <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Pegawai yang Direkomendasi</h2>
    </div>

    <div class="md:col-span-2">
        <label class="block font-medium mb-1">Pilih Pegawai (ASN)</label>
        <select name="pegawai_id" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
            <option value="">-- Tidak Ada --</option>
            @foreach($asns as $asn)
                <option value="{{ $asn->id }}" {{ old('pegawai_id', $sr->pegawai_id ?? '') == $asn->id ? 'selected' : '' }}>
                    {{ $asn->nama }} {{ $asn->nip ? '(' . $asn->nip . ')' : '' }}
                </option>
            @endforeach
        </select>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Unit Kerja diambil otomatis dari data pegawai.</p>
    </div>

    <div class="md:col-span-2">
        <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Studi Lanjut</h2>
    </div>

    <div>
        <label class="block font-medium mb-1">Nama Universitas</label>
        <input type="text" name="nama_universitas" value="{{ old('nama_universitas', $sr->nama_universitas ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>
    <div>
        <label class="block font-medium mb-1">Program Studi</label>
        <input type="text" name="program_studi" value="{{ old('program_studi', $sr->program_studi ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>

    <div class="md:col-span-2">
        <label class="block font-medium mb-1">Pertimbangan Rekomendasi</label>
        <textarea name="pertimbangan" rows="6" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">{{ old('pertimbangan', $sr->pertimbangan ?? '') }}</textarea>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Setiap baris akan ditampilkan sebagai item bernomor.</p>
    </div>

    <div class="md:col-span-2">
        <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Penandatangan</h2>
    </div>

    <div class="md:col-span-2">
        <label class="block font-medium mb-1">Pilih Penandatangan</label>
        <select name="penandatangan_id" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
            <option value="">-- Pilih Penandatangan --</option>
            @foreach($asns as $asn)
                <option value="{{ $asn->id }}" {{ old('penandatangan_id', $sr->penandatangan_id ?? $defaultPenandatanganId) == $asn->id ? 'selected' : '' }}>
                    {{ $asn->nama }} {{ $asn->nip ? '(' . $asn->nip . ')' : '' }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block font-medium mb-1">Tanggal Ditetapkan</label>
        <input type="date" name="tanggal_ditetapkan" value="{{ old('tanggal_ditetapkan', optional($sr->tanggal_ditetapkan ?? null)->format('Y-m-d')) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>
</div>
