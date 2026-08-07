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
<tr class="peserta-row border-b dark:border-gray-700">
    <td class="px-2 py-2">
        <select name="peserta[{{ $index ?? '__INDEX__' }}][pegawai_id][]" multiple class="pegawai-select2 w-full border rounded px-2 py-1 text-sm dark:bg-gray-700 dark:text-gray-100">
            @php
                $selectedPegawai = $item['pegawai_id'] ?? [];
                if (!is_array($selectedPegawai)) {
                    $selectedPegawai = [$selectedPegawai];
                }
            @endphp
            @foreach($asns as $asn)
                <option value="{{ $asn->id }}" {{ in_array($asn->id, $selectedPegawai) ? 'selected' : '' }}>
                    {{ $asn->nama }} {{ $asn->nip ? '(' . $asn->nip . ')' : '' }}
                </option>
            @endforeach
        </select>
    </td>
    <td class="px-2 py-2">
        <select name="peserta[{{ $index ?? '__INDEX__' }}][siswa_id]" class="w-full border rounded px-2 py-1 text-sm dark:bg-gray-700 dark:text-gray-100">
            <option value="">-- Pilih Siswa --</option>
            @foreach($siswas as $siswa)
                <option value="{{ $siswa->id }}" {{ (isset($item['siswa_id']) && $item['siswa_id'] == $siswa->id) ? 'selected' : '' }}>
                    {{ $siswa->nama }}
                </option>
            @endforeach
        </select>
    </td>
    <td class="px-2 py-2">
        <input type="date" name="peserta[{{ $index ?? '__INDEX__' }}][tgl_awal_kegiatan]" value="{{ $item['tgl_awal_kegiatan'] ?? '' }}" class="w-full border rounded px-2 py-1 text-sm dark:bg-gray-700 dark:text-gray-100">
    </td>
    <td class="px-2 py-2">
        <input type="date" name="peserta[{{ $index ?? '__INDEX__' }}][tgl_akhir_kegiatan]" value="{{ $item['tgl_akhir_kegiatan'] ?? '' }}" class="w-full border rounded px-2 py-1 text-sm dark:bg-gray-700 dark:text-gray-100">
    </td>
    
    {{-- Tempat Kegiatan Multiline/Multi-item --}}
    <td class="px-2 py-2" style="width: 320px; min-width: 320px;">
        <div class="tempat-kegiatan-list space-y-2">
            @php
                $tempatValRaw = $item['tempat_kegiatan'] ?? '';

                // Jika data berupa string (misal dari database yang digabung enter atau koma), pecah kembali menjadi array
                if (is_string($tempatValRaw)) {
                    // Memecah berdasarkan baris baru (\r\n atau \n)
                    $tempatList = preg_split('/\r\n|\r|\n/', $tempatValRaw);
                } elseif (is_array($tempatValRaw)) {
                    $tempatList = $tempatValRaw;
                } else {
                    $tempatList = [''];
                }

                // Pastikan minimal ada 1 kotak kosong jika array kosong
                if (empty($tempatList)) {
                    $tempatList = [''];
                }
            @endphp

            @foreach($tempatList as $tempatVal)
                <div class="tempat-item flex items-start gap-2">
                    <textarea name="peserta[{{ $index ?? '__INDEX__' }}][tempat_kegiatan][]" rows="3" placeholder="Masukkan tempat kegiatan..." class="border rounded p-2 text-sm dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:outline-none" style="width: 260px; min-width: 260px;">{{ trim($tempatVal) }}</textarea>
                    <button type="button" class="hapus-tempat bg-red-500 hover:bg-red-700 text-white px-2.5 py-1.5 rounded text-xs mt-1 shrink-0">✕</button>
                </div>
            @endforeach
        </div>
        <button type="button" class="tambah-tempat mt-2.5 bg-green-500 hover:bg-green-700 text-white text-xs font-bold py-1.5 px-3 rounded shadow-sm">+ Tambah Tempat</button>
    </td>

    <td class="px-2 py-2 text-center">
        <button type="button" class="hapus-peserta bg-red-500 hover:bg-red-700 text-white text-xs font-bold py-1 px-2 rounded">Hapus Baris</button>
    </td>
</tr>
