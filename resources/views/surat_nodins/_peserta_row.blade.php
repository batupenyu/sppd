@php
    $item = $item ?? [
        'pegawai_id' => '',
        'siswa_id' => '',
        'tanggal_kegiatan' => '',
        'tempat_kegiatan' => '',
    ];
@endphp
<div class="peserta-row grid grid-cols-1 md:grid-cols-5 gap-4 mb-4 p-4 border rounded">
    <div>
        <label class="block font-medium mb-1">Jenis</label>
        <select name="peserta[{{ $index }}][jenis]" class="peserta-jenis w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
            <option value="pegawai" {{ ($item['pegawai_id'] ?? '') ? 'selected' : '' }}>Pegawai</option>
            <option value="siswa" {{ ($item['siswa_id'] ?? '') ? 'selected' : '' }}>Siswa</option>
        </select>
    </div>
    <div class="pegawai-field">
        <label class="block font-medium mb-1">Pegawai</label>
        <select name="peserta[{{ $index }}][pegawai_id]" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
            <option value="">-- Pilih Pegawai --</option>
            @foreach($asns as $asn)
                <option value="{{ $asn->id }}" {{ ($item['pegawai_id'] ?? '') == $asn->id ? 'selected' : '' }}>
                    {{ $asn->nama }} {{ $asn->nip ? '(' . $asn->nip . ')' : '' }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="siswa-field hidden">
        <label class="block font-medium mb-1">Siswa</label>
        <select name="peserta[{{ $index }}][siswa_id]" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
            <option value="">-- Pilih Siswa --</option>
            @foreach($siswas as $siswa)
                <option value="{{ $siswa->id }}" {{ ($item['siswa_id'] ?? '') == $siswa->id ? 'selected' : '' }}>
                    {{ $siswa->nama }} {{ $siswa->nis ? '(' . $siswa->nis . ')' : '' }}
                </option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block font-medium mb-1">Tanggal Kegiatan</label>
        <input type="date" name="peserta[{{ $index }}][tanggal_kegiatan]" value="{{ $item['tanggal_kegiatan'] ?? '' }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>
    <div>
        <label class="block font-medium mb-1">Tempat Kegiatan</label>
        <input type="text" name="peserta[{{ $index }}][tempat_kegiatan]" value="{{ $item['tempat_kegiatan'] ?? '' }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>
</div>
