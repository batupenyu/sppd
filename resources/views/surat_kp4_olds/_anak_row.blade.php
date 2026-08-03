@php($a = $a ?? null)
@php($i = $i ?? 0)
<tr class="anak-row border-t">
    <td class="px-2 py-2">
        <input type="text" name="anak[{{ $i }}][name]" value="{{ old('anak.' . $i . '.name', $a['name'] ?? '') }}" placeholder="Nama" class="w-full border rounded px-2 py-1 dark:bg-gray-700 dark:text-gray-100">
    </td>
    <td class="px-2 py-2">
        <select name="anak[{{ $i }}][anak]" class="w-full border rounded px-2 py-1 dark:bg-gray-700 dark:text-gray-100">
            <option value="">-- Pilih --</option>
            <option value="AK" {{ old('anak.' . $i . '.anak', $a['anak'] ?? '') == 'AK' ? 'selected' : '' }}>AK</option>
            <option value="AT" {{ old('anak.' . $i . '.anak', $a['anak'] ?? '') == 'AT' ? 'selected' : '' }}>AT</option>
            <option value="AA" {{ old('anak.' . $i . '.anak', $a['anak'] ?? '') == 'AA' ? 'selected' : '' }}>AA</option>
        </select>
    </td>
    <td class="px-2 py-2">
        <input type="date" name="anak[{{ $i }}][tgl_lahir]" value="{{ old('anak.' . $i . '.tgl_lahir', isset($a['tgl_lahir']) ? (is_array($a['tgl_lahir']) ? ($a['tgl_lahir']['date'] ?? '') : \Carbon\Carbon::parse($a['tgl_lahir'])->format('Y-m-d')) : '') }}" class="w-full border rounded px-2 py-1 dark:bg-gray-700 dark:text-gray-100">
    </td>
    <td class="px-2 py-2">
        <input type="text" name="anak[{{ $i }}][perkawinan]" value="{{ old('anak.' . $i . '.perkawinan', $a['perkawinan'] ?? '') }}" placeholder="Belum Pernah Kawin" class="w-full border rounded px-2 py-1 dark:bg-gray-700 dark:text-gray-100">
    </td>
    <td class="px-2 py-2">
        <input type="text" name="anak[{{ $i }}][status_sekolah]" value="{{ old('anak.' . $i . '.status_sekolah', $a['status_sekolah'] ?? '') }}" placeholder="Sekolah/Kuliah" class="w-full border rounded px-2 py-1 dark:bg-gray-700 dark:text-gray-100">
    </td>
    <td class="px-2 py-2">
        <input type="text" name="anak[{{ $i }}][status_beasiswa]" value="{{ old('anak.' . $i . '.status_beasiswa', $a['status_beasiswa'] ?? '') }}" placeholder="Beasiswa/Ikatan Dinas" class="w-full border rounded px-2 py-1 dark:bg-gray-700 dark:text-gray-100">
    </td>
    <td class="px-2 py-2">
        <input type="text" name="anak[{{ $i }}][pekerjaan]" value="{{ old('anak.' . $i . '.pekerjaan', $a['pekerjaan'] ?? '') }}" class="w-full border rounded px-2 py-1 dark:bg-gray-700 dark:text-gray-100">
    </td>
    <td class="px-2 py-2 text-center">
        <select name="anak[{{ $i }}][kat]" class="w-full border rounded px-2 py-1 dark:bg-gray-700 dark:text-gray-100">
            <option value="1" {{ old('anak.' . $i . '.kat', $a['kat'] ?? 1) == 1 ? 'selected' : '' }}>1 (Gaji)</option>
            <option value="2" {{ old('anak.' . $i . '.kat', $a['kat'] ?? 1) == 2 ? 'selected' : '' }}>2 (Bukan Gaji)</option>
        </select>
    </td>
    <td class="px-2 py-2">
        <input type="date" name="anak[{{ $i }}][tgl_meninggal_cerai]" value="{{ old('anak.' . $i . '.tgl_meninggal_cerai', isset($a['tgl_meninggal_cerai']) ? (is_array($a['tgl_meninggal_cerai']) ? ($a['tgl_meninggal_cerai']['date'] ?? '') : \Carbon\Carbon::parse($a['tgl_meninggal_cerai'])->format('Y-m-d')) : '') }}" class="w-full border rounded px-2 py-1 dark:bg-gray-700 dark:text-gray-100">
    </td>
    <td class="px-2 py-2 text-center">
        <button type="button" class="hapus-anak text-red-600 hover:text-red-800" title="Hapus">Hapus</button>
    </td>
</tr>
