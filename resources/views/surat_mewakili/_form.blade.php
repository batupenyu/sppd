@php($suratMewakili = $suratMewakili ?? null)

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="md:col-span-2">
        <h2 class="text-lg font-semibold mb-4 border-b pb-2">Informasi Surat</h2>
    </div>

    <div class="md:col-span-2">
        <label class="block font-medium mb-1">Nomor Surat</label>
        <input type="text" name="nomor" value="{{ old('nomor', $suratMewakili->nomor ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100" placeholder="800/ ...... / SMKN 1 Kb/Dindik/2026">
    </div>

    <div class="md:col-span-2">
        <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Yang Menunjuk (Kepala Sekolah)</h2>
    </div>

    <div class="md:col-span-2">
        <label class="block font-medium mb-1">Pilih Pegawai (ASN)</label>
        <select name="penunjuk_id" id="penunjuk_id" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
            <option value="">-- Pilih / Isi Manual --</option>
            @foreach($asns as $asn)
                <option value="{{ $asn->id }}" {{ old('penunjuk_id', $suratMewakili->penunjuk_id ?? '') == $asn->id ? 'selected' : '' }} data-nama="{{ $asn->nama }}" data-nip="{{ $asn->nip }}" data-pangkat="{{ $asn->pangkat }}" data-golongan="{{ $asn->golongan }}" data-jabatan="{{ $asn->jabatan }}">
                    {{ $asn->nama }} {{ $asn->nip ? '(' . $asn->nip . ')' : '' }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block font-medium mb-1">Nama</label>
        <input type="text" name="penunjuk_nama" id="penunjuk_nama" value="{{ old('penunjuk_nama', $suratMewakili->penunjuk_nama ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>
    <div>
        <label class="block font-medium mb-1">NIP</label>
        <input type="text" name="penunjuk_nip" id="penunjuk_nip" value="{{ old('penunjuk_nip', $suratMewakili->penunjuk_nip ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>
    <div>
        <label class="block font-medium mb-1">Pangkat/Gol</label>
        <input type="text" name="penunjuk_pangkat_gol" id="penunjuk_pangkat_gol" value="{{ old('penunjuk_pangkat_gol', $suratMewakili->penunjuk_pangkat_gol ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>
    <div>
        <label class="block font-medium mb-1">Jabatan</label>
        <input type="text" name="penunjuk_jabatan" id="penunjuk_jabatan" value="{{ old('penunjuk_jabatan', $suratMewakili->penunjuk_jabatan ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>

    <div class="md:col-span-2">
        <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Yang Ditunjuk (Mewakili)</h2>
    </div>

    <div class="md:col-span-2">
        <label class="block font-medium mb-1">Pilih Pegawai (ASN)</label>
        <select name="ditunjuk_id" id="ditunjuk_id" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
            <option value="">-- Pilih / Isi Manual --</option>
            @foreach($asns as $asn)
                <option value="{{ $asn->id }}" {{ old('ditunjuk_id', $suratMewakili->ditunjuk_id ?? '') == $asn->id ? 'selected' : '' }} data-nama="{{ $asn->nama }}" data-nip="{{ $asn->nip }}" data-jabatan="{{ $asn->jabatan }}">
                    {{ $asn->nama }} {{ $asn->nip ? '(' . $asn->nip . ')' : '' }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block font-medium mb-1">Nama</label>
        <input type="text" name="ditunjuk_nama" id="ditunjuk_nama" value="{{ old('ditunjuk_nama', $suratMewakili->ditunjuk_nama ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>
    <div>
        <label class="block font-medium mb-1">NIP</label>
        <input type="text" name="ditunjuk_nip" id="ditunjuk_nip" value="{{ old('ditunjuk_nip', $suratMewakili->ditunjuk_nip ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>
    <div>
        <label class="block font-medium mb-1">Instansi</label>
        <input type="text" name="ditunjuk_instansi" id="ditunjuk_instansi" value="{{ old('ditunjuk_instansi', $suratMewakili->ditunjuk_instansi ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>
    <div>
        <label class="block font-medium mb-1">Jabatan</label>
        <input type="text" name="ditunjuk_jabatan" id="ditunjuk_jabatan" value="{{ old('ditunjuk_jabatan', $suratMewakili->ditunjuk_jabatan ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>

    <div class="md:col-span-2">
        <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Isi Surat</h2>
    </div>

    <div class="md:col-span-2">
        <label class="block font-medium mb-1">Dikarenakan</label>
        <textarea name="dikarenakan" rows="2" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">{{ old('dikarenakan', $suratMewakili->dikarenakan ?? 'melaksanakan dinas ke luar daerah') }}</textarea>
    </div>

    <div class="md:col-span-2">
        <label class="block font-medium mb-1">Keterangan Mewakili</label>
        <textarea name="keterangan_mewakili" rows="3" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">{{ old('keterangan_mewakili', $suratMewakili->keterangan_mewakili ?? 'Untuk mewakili kepala SMK Negeri 1 Koba, selama tidak melaksanakan Dinas, dengan ketentuan:') }}</textarea>
    </div>

    <div class="md:col-span-2">
        <label class="block font-medium mb-1">Penutup</label>
        <textarea name="penutup" rows="3" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">{{ old('penutup', $suratMewakili->penutup ?? 'Demikian untuk dapat dilaksanakan dengan rasa tanggung jawab dan melaporkan pelaksanaan tugas kepada Kepala Dinas Pendidikan Provinsi Kepulauan Bangka Belitung.') }}</textarea>
    </div>

    <div class="md:col-span-2">
        <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Penetapan</h2>
    </div>

    <div>
        <label class="block font-medium mb-1">Dikeluarkan Di</label>
        <input type="text" name="dikeluarkan_di" value="{{ old('dikeluarkan_di', $suratMewakili->dikeluarkan_di ?? 'Koba') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>
    <div>
        <label class="block font-medium mb-1">Tanggal Dikeluarkan</label>
        <input type="date" name="tanggal_dikeluarkan" value="{{ old('tanggal_dikeluarkan', optional($suratMewakili->tanggal_dikeluarkan ?? null)->format('Y-m-d')) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>
    <div>
        <label class="block font-medium mb-1">Tanggal Awal</label>
        <input type="date" name="tanggal_awal" value="{{ old('tanggal_awal', optional($suratMewakili->tanggal_awal ?? null)->format('Y-m-d')) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>
    <div>
        <label class="block font-medium mb-1">Tanggal Akhir</label>
        <input type="date" name="tanggal_akhir" value="{{ old('tanggal_akhir', optional($suratMewakili->tanggal_akhir ?? null)->format('Y-m-d')) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        function bindAutoFill(selectId, prefix) {
            const select = document.getElementById(selectId);
            if (!select) return;
            select.addEventListener('change', function () {
                const opt = select.options[select.selectedIndex];
                const set = (id, val) => { const el = document.getElementById(id); if (el) el.value = val || ''; };
                set(prefix + '_nama', opt.getAttribute('data-nama'));
                set(prefix + '_nip', opt.getAttribute('data-nip'));
                if (prefix === 'penunjuk') {
                    set(prefix + '_pangkat_gol', (opt.getAttribute('data-pangkat') || '') + (opt.getAttribute('data-golongan') ? ' / ' + opt.getAttribute('data-golongan') : ''));
                }
                set(prefix + '_jabatan', opt.getAttribute('data-jabatan'));
            });
        }
        bindAutoFill('penunjuk_id', 'penunjuk');
        bindAutoFill('ditunjuk_id', 'ditunjuk');
    });
</script>
