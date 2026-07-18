@php($s = $suratPanggilanSiswa ?? null)

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="md:col-span-2">
        <h2 class="text-lg font-semibold mb-4 border-b pb-2">Data Umum</h2>
    </div>

    <div class="md:col-span-2">
        <label class="block font-medium mb-1">Nomor Surat</label>
        <input type="text" name="nomor_surat" value="{{ old('nomor_surat', $s->nomor_surat ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>

    <div class="md:col-span-2">
        <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Data Siswa</h2>
    </div>

    <div class="md:col-span-2">
        <label class="block font-medium mb-1">Pilih Siswa</label>
        <select name="siswa_id" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
            <option value="">-- Pilih Siswa --</option>
            @foreach($siswas as $siswa)
                <option value="{{ $siswa->id }}" {{ old('siswa_id', $s->siswa_id ?? '') == $siswa->id ? 'selected' : '' }}>
                    {{ $siswa->nama }} {{ $siswa->nis ? '(' . $siswa->nis . ')' : '' }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block font-medium mb-1">Keterangan Panggilan</label>
        <select name="keterangan_panggilan" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
            <option value="">-- Pilih Keterangan --</option>
            <option value="perilaku" {{ old('keterangan_panggilan', $s->keterangan_panggilan ?? '') == 'perilaku' ? 'selected' : '' }}>Perilaku</option>
            <option value="acara" {{ old('keterangan_panggilan', $s->keterangan_panggilan ?? '') == 'acara' ? 'selected' : '' }}>Acara</option>
        </select>
    </div>

    <div>
        <label class="block font-medium mb-1">Tanggal Panggilan</label>
        <input type="date" name="tanggal_panggilan" value="{{ old('tanggal_panggilan', optional($s->tanggal_panggilan ?? null)->format('Y-m-d')) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>

    <div>
        <label class="block font-medium mb-1">Waktu Panggilan</label>
        <input type="text" name="waktu_panggilan" value="{{ old('waktu_panggilan', $s->waktu_panggilan ?? '') }}" placeholder="Contoh: 08:00 WITA" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>

    <div>
        <label class="block font-medium mb-1">Tempat Panggilan</label>
        <input type="text" name="tempat_panggilan" value="{{ old('tempat_panggilan', $s->tempat_panggilan ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>

    <div class="md:col-span-2">
        <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Penandatangan</h2>
    </div>

    <div>
        <label class="block font-medium mb-1">Wali Kelas</label>
        <select name="wali_kelas_id" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
            <option value="">-- Pilih Wali Kelas --</option>
            @foreach($asns as $asn)
                <option value="{{ $asn->id }}" {{ old('wali_kelas_id', $s->wali_kelas_id ?? '') == $asn->id ? 'selected' : '' }}>
                    {{ $asn->nama }} {{ $asn->nip ? '(' . $asn->nip . ')' : '' }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block font-medium mb-1">Guru BK</label>
        <select name="guru_bk_id" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
            <option value="">-- Pilih Guru BK --</option>
            @foreach($asns as $asn)
                <option value="{{ $asn->id }}" {{ old('guru_bk_id', $s->guru_bk_id ?? '') == $asn->id ? 'selected' : '' }}>
                    {{ $asn->nama }} {{ $asn->nip ? '(' . $asn->nip . ')' : '' }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="md:col-span-2">
        <label class="block font-medium mb-1">Wakasek Kesiswaan</label>
        <select name="wakasek_kesiswaan_id" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
            <option value="">-- Pilih Wakasek Kesiswaan --</option>
            @foreach($asns as $asn)
                <option value="{{ $asn->id }}" {{ old('wakasek_kesiswaan_id', $s->wakasek_kesiswaan_id ?? '') == $asn->id ? 'selected' : '' }}>
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
        <input type="text" name="tempat_ditetapkan" value="{{ old('tempat_ditetapkan', $s->tempat_ditetapkan ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>
    <div>
        <label class="block font-medium mb-1">Tanggal Ditetapkan</label>
        <input type="date" name="tanggal_ditetapkan" value="{{ old('tanggal_ditetapkan', optional($s->tanggal_ditetapkan ?? null)->format('Y-m-d')) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>
</div>
