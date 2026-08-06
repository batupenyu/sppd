@php($s = $suratPenarikanSiswa ?? null)

<div id="form-tabs">
    {{-- ============ NAVBAR TAB ============ --}}
    <div class="sticky top-0 z-20 -mx-6 px-6 py-2 mb-6 bg-white/90 dark:bg-gray-800/90 backdrop-blur border-b dark:border-gray-700">
        <nav class="flex flex-wrap gap-1 text-sm">
            <button type="button" data-tab="data-siswa" onclick="switchTab('data-siswa')"
                class="tab-btn px-3 py-1.5 rounded-full font-medium transition bg-blue-600 text-white">Data Siswa</button>

            <button type="button" data-tab="ortu-wali" onclick="switchTab('ortu-wali')"
                class="tab-btn px-3 py-1.5 rounded-full font-medium transition text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Orang Tua/Wali</button>

            <button type="button" data-tab="sekolah-tujuan" onclick="switchTab('sekolah-tujuan')"
                class="tab-btn px-3 py-1.5 rounded-full font-medium transition text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Sekolah Tujuan</button>

            <button type="button" data-tab="penandatangan" onclick="switchTab('penandatangan')"
                class="tab-btn px-3 py-1.5 rounded-full font-medium transition text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Penandatangan</button>

            <button type="button" data-tab="cabang-dinas" onclick="switchTab('cabang-dinas')"
                class="tab-btn px-3 py-1.5 rounded-full font-medium transition text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Cabang Dinas</button>
        </nav>
    </div>
    {{-- ============ END NAVBAR ============ --}}

    {{-- ============ TAB: DATA SISWA ============ --}}
    <div id="tab-data-siswa" class="tab-content grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="md:col-span-2">
            <h2 class="text-lg font-semibold mb-4 border-b pb-2">Data Siswa</h2>
        </div>

        <div class="md:col-span-2">
            <label class="block font-medium mb-1">Nomor Surat</label>
            <input type="text" name="nomor_surat" value="{{ old('nomor_surat', $s->nomor_surat ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
        </div>

        <div>
            <label class="block font-medium mb-1">Nama Sekolah Asal</label>
            <input type="text" name="nama_sekolah_asal" value="{{ old('nama_sekolah_asal', $s->nama_sekolah_asal ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
        </div>
        <div>
            <label class="block font-medium mb-1">Nama Kota Sekolah</label>
            <input type="text" name="nama_kota_sekolah" value="{{ old('nama_kota_sekolah', $s->nama_kota_sekolah ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
        </div>

        <div>
            <label class="block font-medium mb-1">Nama Siswa</label>
            <input type="text" name="nama_siswa" value="{{ old('nama_siswa', $s->nama_siswa ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
        </div>
        <div>
            <label class="block font-medium mb-1">NIS / NISN</label>
            <div class="flex gap-2">
                <input type="text" name="nis" value="{{ old('nis', $s->nis ?? '') }}" placeholder="NIS" class="w-1/2 border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                <input type="text" name="nisn" value="{{ old('nisn', $s->nisn ?? '') }}" placeholder="NISN" class="w-1/2 border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
            </div>
        </div>

        <div>
            <label class="block font-medium mb-1">Kelas/Jurusan</label>
            <input type="text" name="kelas_jurusan" value="{{ old('kelas_jurusan', $s->kelas_jurusan ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
        </div>
        <div>
            <label class="block font-medium mb-1">Tempat, Tanggal Lahir</label>
            <input type="text" name="tempat_tanggal_lahir" value="{{ old('tempat_tanggal_lahir', $s->tempat_tanggal_lahir ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
        </div>

        <div class="md:col-span-2">
            <label class="block font-medium mb-1">Kop Surat Sekolah</label>
            <select name="kop_surat_sekolah" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                <option value="">-- Pilih Kop Surat Sekolah --</option>
                @foreach($logos as $logo)
                    <option value="{{ $logo->name }}" {{ old('kop_surat_sekolah', $s->kop_surat_sekolah ?? '') == $logo->name ? 'selected' : '' }}>
                        {{ $logo->name ?: 'Tanpa Nama' }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- ============ TAB: ORANG TUA / WALI ============ --}}
    <div id="tab-ortu-wali" class="tab-content hidden grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="md:col-span-2">
            <h2 class="text-lg font-semibold mb-4 border-b pb-2">Orang Tua / Wali</h2>
        </div>

        <div>
            <label class="block font-medium mb-1">Nama Orang Tua/Wali</label>
            <input type="text" name="nama_orang_tua" value="{{ old('nama_orang_tua', $s->nama_orang_tua ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
        </div>
        <div>
            <label class="block font-medium mb-1">Pekerjaan</label>
            <input type="text" name="pekerjaan_orang_tua" value="{{ old('pekerjaan_orang_tua', $s->pekerjaan_orang_tua ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
        </div>

        <div class="md:col-span-2">
            <label class="block font-medium mb-1">Alamat Rumah</label>
            <input type="text" name="alamat_rumah" value="{{ old('alamat_rumah', $s->alamat_rumah ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
        </div>

        <div>
            <label class="block font-medium mb-1">No. HP/Telepon</label>
            <input type="text" name="no_hp" value="{{ old('no_hp', $s->no_hp ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
        </div>
    </div>

    {{-- ============ TAB: SEKOLAH TUJUAN & ALASAN ============ --}}
    <div id="tab-sekolah-tujuan" class="tab-content hidden grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="md:col-span-2">
            <h2 class="text-lg font-semibold mb-4 border-b pb-2">Sekolah Tujuan & Alasan</h2>
        </div>

        <div class="md:col-span-2">
            <label class="block font-medium mb-1">Nama Sekolah Tujuan</label>
            <input type="text" name="nama_sekolah_tujuan" value="{{ old('nama_sekolah_tujuan', $s->nama_sekolah_tujuan ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
        </div>

        <div class="md:col-span-2">
            <label class="block font-medium mb-1">Alasan</label>
            <textarea name="alasan" rows="4" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">{{ old('alasan', $s->alasan ?? '') }}</textarea>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Sebutkan alasan siswa sebelumnya mengundurkan diri.</p>
        </div>
    </div>

    {{-- ============ TAB: PENANDATANGAN ============ --}}
    <div id="tab-penandatangan" class="tab-content hidden grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="md:col-span-2">
            <h2 class="text-lg font-semibold mb-4 border-b pb-2">Penandatangan</h2>
        </div>

        <div class="md:col-span-2">
            <label class="block font-medium mb-1">Pilih Penandatangan (Kepala Sekolah)</label>
            <select name="pegawai_id" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                <option value="">-- Pilih Penandatangan --</option>
                @foreach($asns as $asn)
                    <option value="{{ $asn->id }}" {{ old('pegawai_id', $s->pegawai_id ?? $defaultPenandatanganId) == $asn->id ? 'selected' : '' }}>
                        {{ $asn->nama }} {{ $asn->nip ? '(' . $asn->nip . ')' : '' }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block font-medium mb-1">Tanggal Surat</label>
            <input type="date" name="tanggal_surat" value="{{ old('tanggal_surat', optional($s->tanggal_surat ?? null)->format('Y-m-d')) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
        </div>
    </div>

    {{-- ============ TAB: CABANG DINAS PENDIDIKAN ============ --}}
    <div id="tab-cabang-dinas" class="tab-content hidden grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="md:col-span-2">
            <h2 class="text-lg font-semibold mb-4 border-b pb-2">Cabang Dinas Pendidikan</h2>
        </div>

        <div class="md:col-span-2">
            <label class="block font-medium mb-1">Pilih Penandatangan (Kepala Cabdin)</label>
            <select name="penandatangan_id" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                <option value="">-- Pilih Penandatangan --</option>
                @foreach($asns as $asn)
                    <option value="{{ $asn->id }}" {{ old('penandatangan_id', $s?->penandatangan_id) == $asn->id ? 'selected' : '' }}>
                        {{ $asn->nama }} {{ $asn->nip ? '(' . $asn->nip . ')' : '' }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="md:col-span-2">
            <label class="block font-medium mb-1">Kop Surat Cabang Dinas</label>
            <select name="kop_surat_cabdin" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                <option value="">-- Pilih Kop Surat Cabdin --</option>
                @foreach($logos as $logo)
                    <option value="{{ $logo->name }}" {{ old('kop_surat_cabdin', $s->kop_surat_cabdin ?? '') == $logo->name ? 'selected' : '' }}>
                        {{ $logo->name ?: 'Tanpa Nama' }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block font-medium mb-1">Nama Wilayah Cabdin</label>
            <input type="text" name="nama_wilayah_cabdinas" value="{{ old('nama_wilayah_cabdinas', $s->nama_wilayah_cabdinas ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
        </div>
        <div>
            <label class="block font-medium mb-1">Nama Kota Cabdin</label>
            <input type="text" name="nama_kota_cabdin" value="{{ old('nama_kota_cabdin', $s->nama_kota_cabdin ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
        </div>

        <div>
            <label class="block font-medium mb-1">Nomor Surat Cabdin</label>
            <input type="text" name="nomor_surat_cabdin" value="{{ old('nomor_surat_cabdin', $s->nomor_surat_cabdin ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
        </div>
        <div>
            <label class="block font-medium mb-1">Tanggal Ditetapkan</label>
            <input type="date" name="tanggal_ditetapkan" value="{{ old('tanggal_ditetapkan', optional($s->tanggal_ditetapkan ?? null)->format('Y-m-d')) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
        </div>
    </div>
</div>

<script>
function switchTab(tabId) {
    const contents = document.querySelectorAll('.tab-content');
    contents.forEach(function(el) {
        el.classList.add('hidden');
    });

    const target = document.getElementById('tab-' + tabId);
    if (target) {
        target.classList.remove('hidden');
    }

    const buttons = document.querySelectorAll('.tab-btn');
    buttons.forEach(function(btn) {
        if (btn.dataset.tab === tabId) {
            btn.classList.remove('text-gray-600', 'dark:text-gray-300', 'hover:bg-gray-100', 'dark:hover:bg-gray-700');
            btn.classList.add('bg-blue-600', 'text-white');
        } else {
            btn.classList.remove('bg-blue-600', 'text-white');
            btn.classList.add('text-gray-600', 'dark:text-gray-300', 'hover:bg-gray-100', 'dark:hover:bg-gray-700');
        }
    });
}
</script>
