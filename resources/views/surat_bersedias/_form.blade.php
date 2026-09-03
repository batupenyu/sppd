@php($suratBersedia = $suratBersedia ?? null)

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="md:col-span-2">
        <h2 class="text-lg font-semibold mb-4 border-b pb-2">Identitas Penanda Tangan</h2>
    </div>

    <div class="md:col-span-2">
        <label class="block font-medium mb-1">Nomor Surat</label>
        <input type="text" name="nomor_surat" value="{{ old('nomor_surat', $suratBersedia->nomor_surat ?? '400.3.6.06 /.........../ SMK.N1.KB / 2026') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>

    <div>
        <label class="block font-medium mb-1">Status Pernyataan <span class="text-red-500">*</span></label>
        <select name="status" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100" required>
            <option value="bersedia" {{ old('status', $suratBersedia->status ?? 'bersedia') === 'bersedia' ? 'selected' : '' }}>Bersedia menerima</option>
            <option value="tidak_bersedia" {{ old('status', $suratBersedia->status ?? 'bersedia') === 'tidak_bersedia' ? 'selected' : '' }}>Tidak bersedia menerima</option>
        </select>
    </div>

    <div class="md:col-span-2">
        <label class="block font-medium mb-1">Isi Surat</label>
        <textarea name="isi_surat" rows="6" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">{{ old('isi_surat', $suratBersedia->isi_surat ?? 'Dengan ini menyatakan bersedia/tidak bersedia menerima Mahasiswa untuk PPLK II di sekolah yang saya pimpin.') }}</textarea>
    </div>

    <div class="md:col-span-2">
        <label class="block font-medium mb-1">Penutup Surat</label>
        <textarea name="penutup_surat" rows="4" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">{{ old('penutup_surat', $suratBersedia->penutup_surat ?? 'Demikian pernyataan ini saya buat untuk digunakan sebagaimana mestinya.') }}</textarea>
    </div>

    <div class="md:col-span-2">
        <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Penandatangan (Sumber Identitas)</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Data nama, NIP, jabatan, alamat, dan HP/WA akan otomatis diambil dari pegawai yang dipilih.</p>
    </div>

    <div class="md:col-span-2">
        <label class="block font-medium mb-1">Pilih Penandatangan</label>
        <select name="penandatangan_id" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
            <option value="">-- Pilih Penandatangan --</option>
            @foreach($asns as $asn)
                <option value="{{ $asn->id }}" {{ old('penandatangan_id', $suratBersedia->penandatangan_id ?? $defaultPenandatanganId) == $asn->id ? 'selected' : '' }}>
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
        <input type="text" name="tempat_ditetapkan" value="{{ old('tempat_ditetapkan', $suratBersedia->tempat_ditetapkan ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>
    <div>
        <label class="block font-medium mb-1">Tanggal Ditetapkan</label>
        <input type="date" name="tanggal_ditetapkan" value="{{ old('tanggal_ditetapkan', optional($suratBersedia->tanggal_ditetapkan ?? null)->format('Y-m-d')) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>
</div>
