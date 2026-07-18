@php($sr = $suratResmi ?? null)
@php($selectedPegawai = old('pegawai_ids', $sr && $sr->pegawai ? $sr->pegawai->pluck('id')->toArray() : []))

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="md:col-span-2">
        <h2 class="text-lg font-semibold mb-4 border-b pb-2">Kepala Surat</h2>
    </div>

    <div>
        <label class="block font-medium mb-1">Nomor</label>
        <input type="text" name="nomor" value="{{ old('nomor', $sr->nomor ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>
    <div>
        <label class="block font-medium mb-1">Sifat</label>
        <input type="text" name="sifat" value="{{ old('sifat', $sr->sifat ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>

    <div>
        <label class="block font-medium mb-1">Lampiran</label>
        <input type="text" name="lampiran" value="{{ old('lampiran', $sr->lampiran ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>
    <div>
        <label class="block font-medium mb-1">Perihal</label>
        <input type="text" name="perihal" value="{{ old('perihal', $sr->perihal ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>

    <div class="md:col-span-2">
        <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Tujuan Surat</h2>
    </div>

    <div>
        <label class="block font-medium mb-1">Yth. (Pejabat Tujuan)</label>
        <input type="text" name="pejabat_tujuan_surat" value="{{ old('pejabat_tujuan_surat', $sr->pejabat_tujuan_surat ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>
    <div>
        <label class="block font-medium mb-1">Kota Tujuan</label>
        <input type="text" name="kota_tujuan_surat" value="{{ old('kota_tujuan_surat', $sr->kota_tujuan_surat ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>

    <div class="md:col-span-2">
        <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Pegawai yang Dimaksud</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Dapat memilih lebih dari satu pegawai (tekan Ctrl/Cmd untuk multi-pilih).</p>
    </div>

    <div class="md:col-span-2">
        <label class="block font-medium mb-1">Pilih Pegawai</label>
        <select name="pegawai_ids[]" multiple class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100" size="6">
            @foreach($asns as $asn)
                <option value="{{ $asn->id }}" {{ in_array($asn->id, $selectedPegawai) ? 'selected' : '' }}>
                    {{ $asn->nama }} {{ $asn->nip ? '(' . $asn->nip . ')' : '' }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="md:col-span-2">
        <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Detail Kegiatan</h2>
    </div>

    <div>
        <label class="block font-medium mb-1">Hari/Tanggal Kegiatan</label>
        <input type="date" name="tanggal_kegiatan" value="{{ old('tanggal_kegiatan', optional($sr->tanggal_kegiatan ?? null)->format('Y-m-d')) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>
    <div>
        <label class="block font-medium mb-1">Waktu Kegiatan</label>
        <input type="text" name="waktu_kegiatan" value="{{ old('waktu_kegiatan', $sr->waktu_kegiatan ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>

    <div class="md:col-span-2">
        <label class="block font-medium mb-1">Tempat Kegiatan</label>
        <input type="text" name="tempat_kegiatan" value="{{ old('tempat_kegiatan', $sr->tempat_kegiatan ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>

    <div class="md:col-span-2">
        <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Isi Surat</h2>
    </div>

    <div class="md:col-span-2">
        <label class="block font-medium mb-1">Pembuka Surat</label>
        <textarea name="pembuka_surat" rows="3" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">{{ old('pembuka_surat', $sr->pembuka_surat ?? '') }}</textarea>
    </div>

    <div class="md:col-span-2">
        <label class="block font-medium mb-1">Isi Surat</label>
        <textarea name="isi_surat" rows="6" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">{{ old('isi_surat', $sr->isi_surat ?? '') }}</textarea>
    </div>

    <div class="md:col-span-2">
        <label class="block font-medium mb-1">Penutup Surat</label>
        <textarea name="penutup_surat" rows="3" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">{{ old('penutup_surat', $sr->penutup_surat ?? '') }}</textarea>
    </div>

    <div class="md:col-span-2">
        <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Penandatangan & Penetapan</h2>
    </div>

    <div class="md:col-span-2">
        <label class="block font-medium mb-1">Pilih Penandatangan</label>
        <select name="penandatangan_id" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
            <option value="">-- Pilih Penandatangan --</option>
            @foreach($asns as $asn)
                <option value="{{ $asn->id }}" {{ old('penandatangan_id', $sr->penandatangan_id ?? '') == $asn->id ? 'selected' : '' }}>
                    {{ $asn->nama }} {{ $asn->nip ? '(' . $asn->nip . ')' : '' }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block font-medium mb-1">Tempat Ditetapkan</label>
        <input type="text" name="tempat_ditetapkan" value="{{ old('tempat_ditetapkan', $sr->tempat_ditetapkan ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>
    <div>
        <label class="block font-medium mb-1">Tanggal Ditetapkan</label>
        <input type="date" name="tanggal_ditetapkan" value="{{ old('tanggal_ditetapkan', optional($sr->tanggal_ditetapkan ?? null)->format('Y-m-d')) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>
</div>
