@php($suratNodin = $suratNodin ?? null)

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="md:col-span-2">
        <h2 class="text-lg font-semibold mb-4 border-b pb-2">Data Umum</h2>
    </div>

    <div>
        <label class="block font-medium mb-1">Nomor</label>
        <input type="text" name="nomor" value="{{ old('nomor', $suratNodin->nomor ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>

    <div>
        <label class="block font-medium mb-1">Sifat</label>
        <input type="text" name="sifat" value="{{ old('sifat', $suratNodin->sifat ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>

    <div>
        <label class="block font-medium mb-1">Lampiran</label>
        <input type="text" name="lampiran" value="{{ old('lampiran', $suratNodin->lampiran ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>

    <div>
        <label class="block font-medium mb-1">Hal</label>
        <input type="text" name="hal" value="{{ old('hal', $suratNodin->hal ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>

    <div class="md:col-span-2">
        <label class="block font-medium mb-1">Yth.</label>
        <input type="text" name="kepada" value="{{ old('kepada', $suratNodin->kepada ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>

    <div class="md:col-span-2">
        <label class="block font-medium mb-1">Dari</label>
        <input type="text" name="dari" value="{{ old('dari', $suratNodin->dari ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>

    <div>
        <label class="block font-medium mb-1">Tanggal</label>
        <input type="date" name="tanggal" value="{{ old('tanggal', optional($suratNodin->tanggal ?? null)->format('Y-m-d')) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>

    <div class="md:col-span-2">
        <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Isi Surat</h2>
    </div>

    <div class="md:col-span-2">
        <label class="block font-medium mb-1">Dasar Surat</label>
        <textarea name="dasar_surat" rows="3" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">{{ old('dasar_surat', $suratNodin->dasar_surat ?? '') }}</textarea>
    </div>

    <div class="md:col-span-2">
        <label class="block font-medium mb-1">Isi Surat</label>
        <textarea name="isi_surat" rows="4" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">{{ old('isi_surat', $suratNodin->isi_surat ?? '') }}</textarea>
    </div>

    <div class="md:col-span-2">
        <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Peserta</h2>
    </div>

    <div class="md:col-span-2">
        <label class="block font-medium mb-1">Kop Surat</label>
        <select name="kop_surat" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
            <option value="">-- Pilih Kop Surat --</option>
            @foreach($logos as $logo)
                <option value="{{ $logo->name }}" {{ old('kop_surat', $suratNodin->kop_surat ?? '') == $logo->name ? 'selected' : '' }}>
                    {{ $logo->name ?: 'Tanpa Nama' }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="md:col-span-2">
        <label class="block font-medium mb-1">Pilih Pegawai</label>
        <select name="pegawai_ids[]" id="pegawai-select" multiple class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
            @foreach($asns as $asn)
                <option value="{{ $asn->id }}" {{ (old('pegawai_ids') && in_array($asn->id, old('pegawai_ids')) ?: (isset($suratNodin) && $suratNodin->pesertaSuratUsulans->where('pegawai_id', $asn->id)->count() > 0)) ? 'selected' : '' }}>
                    {{ $asn->nama }} {{ $asn->nip ? '(' . $asn->nip . ')' : '' }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="md:col-span-2">
        <label class="block font-medium mb-1">Pilih Siswa</label>
        <select name="siswa_ids[]" id="siswa-select" multiple class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
            @foreach($siswas as $siswa)
                <option value="{{ $siswa->id }}" {{ (old('siswa_ids') && in_array($siswa->id, old('siswa_ids')) ?: (isset($suratNodin) && $suratNodin->pesertaSuratUsulans->where('siswa_id', $siswa->id)->count() > 0)) ? 'selected' : '' }}>
                    {{ $siswa->nama }} {{ $siswa->nis ? '(' . $siswa->nis . ')' : '' }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block font-medium mb-1">Tanggal Kegiatan</label>
        <input type="date" name="tanggal_kegiatan" value="{{ old('tanggal_kegiatan', isset($suratNodin) && $suratNodin->pesertaSuratUsulans->first() ? \Carbon\Carbon::parse($suratNodin->pesertaSuratUsulans->first()->tanggal_kegiatan)->format('Y-m-d') : '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>

    <div>
        <label class="block font-medium mb-1">Tempat Kegiatan</label>
        <input type="text" name="tempat_kegiatan" value="{{ old('tempat_kegiatan', isset($suratNodin) && $suratNodin->pesertaSuratUsulans->first() ? $suratNodin->pesertaSuratUsulans->first()->tempat_kegiatan : '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            $('#pegawai-select').select2({
                placeholder: '-- Pilih Pegawai --',
                allowClear: true
            });
            $('#siswa-select').select2({
                placeholder: '-- Pilih Siswa --',
                allowClear: true
            });
        });
    </script>

    <div class="md:col-span-2">
        <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Penandatangan</h2>
    </div>

    <div class="md:col-span-2">
        <label class="block font-medium mb-1">Pilih Penandatangan</label>
        <select name="penandatangan_id" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
            <option value="">-- Pilih Penandatangan --</option>
            @foreach($asns as $asn)
                <option value="{{ $asn->id }}" {{ old('penandatangan_id', $suratNodin->penandatangan_id ?? '') == $asn->id ? 'selected' : '' }}>
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
        <input type="text" name="tempat_ditetapkan" value="{{ old('tempat_ditetapkan', $suratNodin->tempat_ditetapkan ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>
    <div>
        <label class="block font-medium mb-1">Tanggal Ditetapkan</label>
        <input type="date" name="tanggal_ditetapkan" value="{{ old('tanggal_ditetapkan', optional($suratNodin->tanggal_ditetapkan ?? null)->format('Y-m-d')) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>
</div>


