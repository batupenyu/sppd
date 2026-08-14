@php($pm = $persetujuanMagang ?? null)

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="md:col-span-2">
        <h2 class="text-lg font-semibold mb-4 border-b pb-2">Detail Surat</h2>
    </div>

    <div class="md:col-span-2">
        <label class="block font-medium mb-1">Nomor Surat</label>
        <input type="text" name="nomor_surat" value="{{ old('nomor_surat', $pm->nomor_surat ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>

    <div>
        <label class="block font-medium mb-1">Sifat</label>
        <input type="text" name="sifat" value="{{ old('sifat', $pm->sifat ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>
    <div>
        <label class="block font-medium mb-1">Lampiran</label>
        <input type="text" name="lampiran" value="{{ old('lampiran', $pm->lampiran ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>

    <div class="md:col-span-2">
        <label class="block font-medium mb-1">Perihal</label>
        <input type="text" name="perihal" value="{{ old('perihal', $pm->perihal ?? 'Permohonan Magang') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>

    <div class="md:col-span-2">
        <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Tujuan Surat</h2>
    </div>

    <div class="md:col-span-2">
        <label class="block font-medium mb-1">Alamat Tujuan (Kampus)</label>
        <textarea name="tujuan_surat" rows="3" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">{{ old('tujuan_surat', $pm->tujuan_surat ?? '') }}</textarea>
    </div>

    <div>
        <label class="block font-medium mb-1">Nomor Surat dari Kampus</label>
        <input type="text" name="nomor_surat_kampus" value="{{ old('nomor_surat_kampus', $pm->nomor_surat_kampus ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>
    <div>
        <label class="block font-medium mb-1">Tanggal Surat dari Kampus</label>
        <input type="date" name="tanggal_surat_kampus" value="{{ old('tanggal_surat_kampus', optional($pm->tanggal_surat_kampus ?? null)->format('Y-m-d')) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>

    <div class="md:col-span-2">
        <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Identitas Instansi / SMK</h2>
    </div>

    <div class="md:col-span-2">
        <label class="block font-medium mb-1">Nama Instansi / Unit</label>
        <input type="text" name="nama_instansi" value="{{ old('nama_instansi', $pm->nama_instansi ?? 'SMK Negeri 1 Koba') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>
    <div class="md:col-span-2">
        <label class="block font-medium mb-1">Alamat Instansi</label>
        <textarea name="alamat_instansi" rows="2" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">{{ old('alamat_instansi', $pm->alamat_instansi ?? 'Jalan Raya Koba Km. 42, Desa Penyak, Kab. Bangka Tengah') }}</textarea>
    </div>

    <div>
        <label class="block font-medium mb-1">Tanggal Mulai Magang</label>
        <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai', optional($pm->tanggal_mulai ?? null)->format('Y-m-d')) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>
    <div>
        <label class="block font-medium mb-1">Tanggal Selesai Magang</label>
        <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai', optional($pm->tanggal_selesai ?? null)->format('Y-m-d')) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>

    <div class="md:col-span-2">
        <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Daftar Mahasiswa</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Tambah daftar mahasiswa yang akan magang.</p>
    </div>

    <div class="md:col-span-2">
        <table class="min-w-full border rounded" id="mahasiswa-table">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-4 py-2 text-left">No</th>
                    <th class="px-4 py-2 text-left">Nama Mahasiswa</th>
                    <th class="px-4 py-2 text-left">NIM</th>
                    <th class="px-4 py-2 text-left">Program Studi</th>
                    <th class="px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                <?php
                    $mahasiswas = old('mahasiswas', ($pm && $pm->mahasiswas) ? $pm->mahasiswas : [['nama' => '', 'nim' => '', 'program_studi' => '']]);
                ?>
                @foreach($mahasiswas as $index => $mahasiswa)
                <tr class="mahasiswa-row">
                    <td class="px-4 py-2">{{ $index + 1 }}</td>
                    <td class="px-4 py-2">
                        <input type="text" name="mahasiswas[{{ $index }}][nama]" value="{{ $mahasiswa['nama'] ?? '' }}" class="w-full border rounded px-2 py-1 dark:bg-gray-700 dark:text-gray-100" placeholder="Nama Mahasiswa">
                    </td>
                    <td class="px-4 py-2">
                        <input type="text" name="mahasiswas[{{ $index }}][nim]" value="{{ $mahasiswa['nim'] ?? '' }}" class="w-full border rounded px-2 py-1 dark:bg-gray-700 dark:text-gray-100" placeholder="NIM">
                    </td>
                    <td class="px-4 py-2">
                        <input type="text" name="mahasiswas[{{ $index }}][program_studi]" value="{{ $mahasiswa['program_studi'] ?? '' }}" class="w-full border rounded px-2 py-1 dark:bg-gray-700 dark:text-gray-100" placeholder="Program Studi">
                    </td>
                    <td class="px-4 py-2 text-center">
                        <button type="button" class="remove-row text-red-600 hover:text-red-800" {{ count($mahasiswas) <= 1 ? 'disabled' : '' }}>Hapus</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <button type="button" id="add-mahasiswa" class="mt-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm">Tambah Mahasiswa</button>
    </div>

    <div class="md:col-span-2">
        <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Penandatangan</h2>
    </div>

    <div class="md:col-span-2">
        <label class="block font-medium mb-1">Pilih Penandatangan</label>
        <select name="penandatangan_id" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
            <option value="">-- Pilih Penandatangan --</option>
            @foreach($asns as $asn)
                <option value="{{ $asn->id }}" {{ old('penandatangan_id', $pm->penandatangan_id ?? $defaultPenandatanganId) == $asn->id ? 'selected' : '' }}>
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
        <input type="text" name="tempat_ditetapkan" value="{{ old('tempat_ditetapkan', $pm->tempat_ditetapkan ?? 'Koba') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>
    <div>
        <label class="block font-medium mb-1">Tanggal Ditetapkan</label>
        <input type="date" name="tanggal_ditetapkan" value="{{ old('tanggal_ditetapkan', optional($pm->tanggal_ditetapkan ?? null)->format('Y-m-d')) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tableBody = document.querySelector('#mahasiswa-table tbody');
    const addBtn = document.getElementById('add-mahasiswa');
    let rowIndex = {{ count(old('mahasiswas', ($pm && $pm->mahasiswas) ? $pm->mahasiswas : [])) }};

    function updateRowNumbers() {
        const rows = tableBody.querySelectorAll('.mahasiswa-row');
        rows.forEach((row, i) => {
            row.querySelector('td:first-child').textContent = i + 1;
        });
    }

    addBtn.addEventListener('click', function() {
        const row = document.createElement('tr');
        row.className = 'mahasiswa-row';
        row.innerHTML = `
            <td class="px-4 py-2">${tableBody.querySelectorAll('.mahasiswa-row').length + 1}</td>
            <td class="px-4 py-2">
                <input type="text" name="mahasiswas[${rowIndex}][nama]" value="" class="w-full border rounded px-2 py-1 dark:bg-gray-700 dark:text-gray-100" placeholder="Nama Mahasiswa">
            </td>
            <td class="px-4 py-2">
                <input type="text" name="mahasiswas[${rowIndex}][nim]" value="" class="w-full border rounded px-2 py-1 dark:bg-gray-700 dark:text-gray-100" placeholder="NIM">
            </td>
            <td class="px-4 py-2">
                <input type="text" name="mahasiswas[${rowIndex}][program_studi]" value="" class="w-full border rounded px-2 py-1 dark:bg-gray-700 dark:text-gray-100" placeholder="Program Studi">
            </td>
            <td class="px-4 py-2 text-center">
                <button type="button" class="remove-row text-red-600 hover:text-red-800">Hapus</button>
            </td>
        `;
        tableBody.appendChild(row);
        rowIndex++;
        updateRowNumbers();
    });

    tableBody.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-row')) {
            const rows = tableBody.querySelectorAll('.mahasiswa-row');
            if (rows.length > 1) {
                e.target.closest('tr').remove();
                updateRowNumbers();
            }
        }
    });
});
</script>
