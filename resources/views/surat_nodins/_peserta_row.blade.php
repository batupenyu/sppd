<?php
    $item = $item ?? [
        'pegawai_id' => '',
        'siswa_id' => '',
        'tgl_awal_kegiatan' => '',
        'tgl_akhir_kegiatan' => '',
        'tempat_kegiatan' => '',
    ];
    $asns = $asns ?? [];
    $siswas = $siswas ?? [];

    $tempatList = $item['tempat_kegiatan'] ?? '';
    if (!is_array($tempatList)) {
        $tempatList = $tempatList !== '' ? explode("\n", $tempatList) : [''];
    }
    $tempatList = array_values(array_filter(array_map('trim', $tempatList), function($v) { return $v !== ''; }));
    if (empty($tempatList)) {
        $tempatList = [''];
    }
?>
<tr class="peserta-row border-t">
    <td class="px-2 py-2">
        <select name="peserta[{{ $index }}][pegawai_id][]" multiple class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100 pegawai-select2">
            <option value="">-- Pilih Pegawai --</option>
            @php
                $selectedPegawaiIds = is_array($item['pegawai_id'] ?? null) ? ($item['pegawai_id'] ?? []) : (($item['pegawai_id'] ?? '') ? [$item['pegawai_id']] : []);
            @endphp
            @foreach($asns as $asn)
                <option value="{{ $asn->id }}" {{ in_array($asn->id, $selectedPegawaiIds) ? 'selected' : '' }}>
                    {{ $asn->nama }} {{ $asn->nip ? '(' . $asn->nip . ')' : '' }}
                </option>
            @endforeach
        </select>
    </td>
    <td class="px-2 py-2">
        <select name="peserta[{{ $index }}][siswa_id]" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
            <option value="">-- Pilih Siswa --</option>
            @foreach($siswas as $siswa)
                <option value="{{ $siswa->id }}" {{ ($item['siswa_id'] ?? '') == $siswa->id ? 'selected' : '' }}>
                    {{ $siswa->nama }} {{ $siswa->nis ? '(' . $siswa->nis . ')' : '' }}
                </option>
            @endforeach
        </select>
    </td>
    <td class="px-2 py-2">
        <input type="date" name="peserta[{{ $index }}][tgl_awal_kegiatan]" value="{{ $item['tgl_awal_kegiatan'] ?? '' }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </td>
    <td class="px-2 py-2">
        <input type="date" name="peserta[{{ $index }}][tgl_akhir_kegiatan]" value="{{ $item['tgl_akhir_kegiatan'] ?? '' }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </td>
    <td class="px-2 py-2">
        <div class="tempat-kegiatan-list space-y-1">
            @foreach($tempatList as $tempat)
                <div class="tempat-item flex gap-1">
                    <input type="text" name="peserta[{{ $index }}][tempat_kegiatan][]" value="{{ $tempat }}" class="flex-1 border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                    <button type="button" class="hapus-tempat text-red-600 hover:text-red-800 text-sm" title="Hapus">Hapus</button>
                </div>
            @endforeach
        </div>
        <button type="button" class="tambah-tempat bg-blue-500 hover:bg-blue-700 text-white text-xs font-bold py-1 px-2 rounded mt-1">+ Tambah Tempat</button>
    </td>
    <td class="px-2 py-2 text-center">
        <button type="button" class="hapus-peserta text-red-600 hover:text-red-800" title="Hapus">Hapus</button>
    </td>
</tr>
