@php($sp = $suratPengantar ?? null)

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="md:col-span-2">
        <h2 class="text-lg font-semibold mb-4 border-b pb-2">Data Umum</h2>
    </div>

    <div class="md:col-span-2">
        <label class="block font-medium mb-1">Nomor Surat</label>
        <input type="text" name="nomor_surat" value="{{ old('nomor_surat', $sp->nomor_surat ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>

    <div>
        <label class="block font-medium mb-1">Tujuan Surat</label>
        <input type="text" name="tujuan_surat" value="{{ old('tujuan_surat', $sp->tujuan_surat ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>

    <div>
        <label class="block font-medium mb-1">Yth.</label>
        <input type="text" name="yth" value="{{ old('yth', $sp->yth ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>

    <div>
        <label class="block font-medium mb-1">Di</label>
        <input type="text" name="di" value="{{ old('di', $sp->di ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>

    <div>
        <label class="block font-medium mb-1">Nomor Telepon</label>
        <input type="text" name="nomor_telepon" value="{{ old('nomor_telepon', $sp->nomor_telepon ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>

    <div class="md:col-span-2">
        <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Isi Surat</h2>
    </div>

    <div class="md:col-span-2">
        <label class="block font-medium mb-1">Naskah Dinas / Barang yang Dikirimkan</label>
        <textarea name="isi_surat" rows="6" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">{{ old('isi_surat', $sp->isi_surat ?? '') }}</textarea>
    </div>

    <div>
        <label class="block font-medium mb-1">Banyaknya</label>
        <input type="text" name="banyaknya" value="{{ old('banyaknya', $sp->banyaknya ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>

    <div>
        <label class="block font-medium mb-1">Keterangan</label>
        <input type="text" name="keterangan" value="{{ old('keterangan', $sp->keterangan ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>

    <div class="md:col-span-2">
        <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Penandatangan</h2>
    </div>

    <div class="md:col-span-2">
        <label class="block font-medium mb-1">Pilih Penandatangan</label>
        <select name="penandatangan_id" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
            <option value="">-- Pilih Penandatangan --</option>
            @foreach($asns as $asn)
                <option value="{{ $asn->id }}" {{ old('penandatangan_id', $sp->penandatangan_id ?? '') == $asn->id ? 'selected' : '' }}>
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
        <input type="text" name="tempat_ditetapkan" value="{{ old('tempat_ditetapkan', $sp->tempat_ditetapkan ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>
    <div>
        <label class="block font-medium mb-1">Tanggal Ditetapkan</label>
        <input type="date" name="tanggal_ditetapkan" value="{{ old('tanggal_ditetapkan', optional($sp->tanggal_ditetapkan ?? null)->format('Y-m-d')) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>
</div>
