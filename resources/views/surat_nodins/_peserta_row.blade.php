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
        <textarea name="peserta[{{ $index }}][tempat_kegiatan]" rows="2" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">{{ $item['tempat_kegiatan'] ?? '' }}</textarea>
    </td>
    <td class="px-2 py-2 text-center">
        <button type="button" class="hapus-peserta text-red-600 hover:text-red-800" title="Hapus">Hapus</button>
    </td>
</tr>
