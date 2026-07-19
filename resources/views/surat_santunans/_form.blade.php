@php($sk = $suratSantunan ?? null)

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="md:col-span-2">
        <h2 class="text-lg font-semibold mb-4 border-b pb-2">Data Umum</h2>
    </div>

    <div class="md:col-span-2">
        <label class="block font-medium mb-1">Nomor Surat</label>
        <input type="text" name="nomor_surat" value="{{ old('nomor_surat', $sk->nomor_surat ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>

    <div>
        <label class="block font-medium mb-1">Sifat</label>
        <input type="text" name="sifat" value="{{ old('sifat', $sk->sifat ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>

    <div>
        <label class="block font-medium mb-1">Lampiran</label>
        <input type="text" name="lampiran" value="{{ old('lampiran', $sk->lampiran ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>

    <div class="md:col-span-2">
        <label class="block font-medium mb-1">Perihal</label>
        <input type="text" name="perihal" value="{{ old('perihal', $sk->perihal ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>

    <div class="md:col-span-2">
        <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Tujuan Surat</h2>
    </div>

    <div>
        <label class="block font-medium mb-1">Instansi Tujuan Surat</label>
        <input type="text" name="instansi_tujuan_surat" value="{{ old('instansi_tujuan_surat', $sk->instansi_tujuan_surat ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>

    <div>
        <label class="block font-medium mb-1">Kota Tujuan Surat</label>
        <input type="text" name="kota_tujuan_surat" value="{{ old('kota_tujuan_surat', $sk->kota_tujuan_surat ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>

    <div class="md:col-span-2">
        <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Penerima Santunan (Pegawai)</h2>
    </div>

    <div class="md:col-span-2">
        <label class="block font-medium mb-1">Pilih Pegawai (ASN)</label>
        <select name="pegawai_id" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
            <option value="">-- Tidak Ada --</option>
            @foreach($asns as $asn)
                <option value="{{ $asn->id }}" {{ old('pegawai_id', $sk->pegawai_id ?? '') == $asn->id ? 'selected' : '' }}>
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
        <select name="penandatangan_id" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
            <option value="">-- Pilih Penandatangan --</option>
            @foreach($asns as $asn)
                <option value="{{ $asn->id }}" {{ old('penandatangan_id', $sk->penandatangan_id ?? $defaultPenandatanganId) == $asn->id ? 'selected' : '' }}>
                    {{ $asn->nama }} {{ $asn->nip ? '(' . $asn->nip . ')' : '' }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="md:col-span-2">
        <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Penetapan</h2>
    </div>

    <div>
        <label class="block font-medium mb-1">Tempat Ditetapkan</label>
        <input type="text" name="tempat_ditetapkan" value="{{ old('tempat_ditetapkan', $sk->tempat_ditetapkan ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>
    <div>
        <label class="block font-medium mb-1">Tanggal Ditetapkan</label>
        <input type="date" name="tanggal_ditetapkan" value="{{ old('tanggal_ditetapkan', optional($sk->tanggal_ditetapkan ?? null)->format('Y-m-d')) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>
</div>
