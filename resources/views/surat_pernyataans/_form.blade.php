@php($suratPernyataan = $suratPernyataan ?? null)

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="md:col-span-2">
        <h2 class="text-lg font-semibold mb-4 border-b pb-2">Isi Surat</h2>
    </div>

    <div class="md:col-span-2">
        <label class="block font-medium mb-1">Pembuka Surat</label>
        <textarea name="pembuka_surat" rows="4" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">{{ old('pembuka_surat', $suratPernyataan->pembuka_surat ?? '') }}</textarea>
    </div>

    <div class="md:col-span-2">
        <label class="block font-medium mb-1">Isi Surat</label>
        <textarea name="isi_surat" rows="6" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">{{ old('isi_surat', $suratPernyataan->isi_surat ?? '') }}</textarea>
    </div>

    <div class="md:col-span-2">
        <label class="block font-medium mb-1">Penutup Surat</label>
        <textarea name="penutup_surat" rows="4" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">{{ old('penutup_surat', $suratPernyataan->penutup_surat ?? '') }}</textarea>
    </div>

    <div class="md:col-span-2">
        <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Pegawai</h2>
    </div>

    <div class="md:col-span-2">
        <label class="block font-medium mb-1">Pilih Pegawai (ASN)</label>
        <select name="pegawai_id" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
            <option value="">-- Tidak Ada --</option>
            @foreach($asns as $asn)
                <option value="{{ $asn->id }}" {{ old('pegawai_id', $suratPernyataan->pegawai_id ?? '') == $asn->id ? 'selected' : '' }}>
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
                <option value="{{ $asn->id }}" {{ old('penandatangan_id', $suratPernyataan->penandatangan_id ?? $defaultPenandatanganId) == $asn->id ? 'selected' : '' }}>
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
        <input type="text" name="tempat_ditetapkan" value="{{ old('tempat_ditetapkan', $suratPernyataan->tempat_ditetapkan ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>
    <div>
        <label class="block font-medium mb-1">Tanggal Ditetapkan</label>
        <input type="date" name="tanggal_ditetapkan" value="{{ old('tanggal_ditetapkan', optional($suratPernyataan->tanggal_ditetapkan ?? null)->format('Y-m-d')) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>
</div>
