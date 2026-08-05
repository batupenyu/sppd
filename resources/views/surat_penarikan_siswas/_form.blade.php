@php($s = $suratPenarikanSiswa ?? null)

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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
        <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Orang Tua / Wali</h2>
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

    <div class="md:col-span-2">
        <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Sekolah Tujuan & Alasan</h2>
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

    <div class="md:col-span-2">
        <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Penandatangan</h2>
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
        <label class="block font-medium mb-1">Nama Kepala Sekolah</label>
        <input type="text" name="nama_kepala_sekolah" value="{{ old('nama_kepala_sekolah', $s->nama_kepala_sekolah ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>
    <div>
        <label class="block font-medium mb-1">NIP Kepala Sekolah</label>
        <input type="text" name="nip_kepala_sekolah" value="{{ old('nip_kepala_sekolah', $s->nip_kepala_sekolah ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>

    <div>
        <label class="block font-medium mb-1">Tanggal Surat</label>
        <input type="date" name="tanggal_surat" value="{{ old('tanggal_surat', optional($s->tanggal_surat ?? null)->format('Y-m-d')) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>

    <div class="md:col-span-2">
        <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Cabang Dinas Pendidikan</h2>
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

    <div>
        <label class="block font-medium mb-1">Nama Kepala Cabang Dinas</label>
        <input type="text" name="nama_kepala_cabdinas" value="{{ old('nama_kepala_cabdinas', $s->nama_kepala_cabdinas ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>
    <div>
        <label class="block font-medium mb-1">NIP Kepala Cabang Dinas</label>
        <input type="text" name="nip_kepala_cabdinas" value="{{ old('nip_kepala_cabdinas', $s->nip_kepala_cabdinas ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>
</div>
