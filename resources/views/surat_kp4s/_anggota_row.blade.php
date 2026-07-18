@php($a = $a ?? null)
@php($i = $i ?? 0)
<tr class="anggota-row border-t">
    <td class="px-2 py-2">
        <input type="text" name="anggota[{{ $i }}][nama]" value="{{ old('anggota.' . $i . '.nama', $a['nama'] ?? '') }}" class="w-full border rounded px-2 py-1 dark:bg-gray-700 dark:text-gray-100">
    </td>
    <td class="px-2 py-2">
        <input type="date" name="anggota[{{ $i }}][tanggal_kelahiran]" value="{{ old('anggota.' . $i . '.tanggal_kelahiran', isset($a['tanggal_kelahiran']) ? (is_array($a['tanggal_kelahiran']) ? ($a['tanggal_kelahiran']['date'] ?? '') : \Carbon\Carbon::parse($a['tanggal_kelahiran'])->format('Y-m-d')) : '') }}" class="w-full border rounded px-2 py-1 dark:bg-gray-700 dark:text-gray-100">
    </td>
    <td class="px-2 py-2">
        <input type="date" name="anggota[{{ $i }}][tanggal_perkawinan]" value="{{ old('anggota.' . $i . '.tanggal_perkawinan', isset($a['tanggal_perkawinan']) ? (is_array($a['tanggal_perkawinan']) ? ($a['tanggal_perkawinan']['date'] ?? '') : \Carbon\Carbon::parse($a['tanggal_perkawinan'])->format('Y-m-d')) : '') }}" class="w-full border rounded px-2 py-1 dark:bg-gray-700 dark:text-gray-100">
    </td>
    <td class="px-2 py-2">
        <input type="text" name="anggota[{{ $i }}][pekerjaan]" value="{{ old('anggota.' . $i . '.pekerjaan', $a['pekerjaan'] ?? '') }}" class="w-full border rounded px-2 py-1 dark:bg-gray-700 dark:text-gray-100">
    </td>
    <td class="px-2 py-2">
        <input type="text" name="anggota[{{ $i }}][keterangan]" value="{{ old('anggota.' . $i . '.keterangan', $a['keterangan'] ?? '') }}" class="w-full border rounded px-2 py-1 dark:bg-gray-700 dark:text-gray-100">
    </td>
    <td class="px-2 py-2 text-center">
        <input type="checkbox" name="anggota[{{ $i }}][mendapat_tunjangan]" value="1" {{ old('anggota.' . $i . '.mendapat_tunjangan', $a['mendapat_tunjangan'] ?? false) ? 'checked' : '' }}>
    </td>
    <td class="px-2 py-2 text-center">
        <button type="button" class="hapus-anggota text-red-600 hover:text-red-800" title="Hapus">Hapus</button>
    </td>
</tr>
