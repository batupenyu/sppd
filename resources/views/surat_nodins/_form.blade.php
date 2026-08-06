@php
    $suratNodin = $suratNodin ?? null;
    $pesertaIndex = 0;
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="md:col-span-2">
        <h2 class="text-lg font-semibold mb-4 border-b pb-2">Data Umum</h2>
    </div>

    <div>
        <label class="block font-medium mb-1">Nomor</label>
        <input type="text" name="nomor" value="{{ old('nomor', $suratNodin->nomor ?? '................................................................') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>

    <div>
        <label class="block font-medium mb-1">Sifat</label>
        <input type="text" name="sifat" value="{{ old('sifat', $suratNodin->sifat ?? 'Penting') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>

    <div>
        <label class="block font-medium mb-1">Lampiran</label>
        <input type="text" name="lampiran" value="{{ old('lampiran', $suratNodin->lampiran ?? '-') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>

    <div>
        <label class="block font-medium mb-1">Hal</label>
        <input type="text" name="hal" value="{{ old('hal', $suratNodin->hal ?? 'Permohonan Izin Perjalanan Dinas') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>

    <div class="md:col-span-2">
        <label class="block font-medium mb-1">Yth.</label>
        <input type="text" name="kepada" value="{{ old('kepada', $suratNodin->kepada ?? 'Yth. Gubernur Kepulauan Bangka Belitung') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>

    <div class="md:col-span-2">
        <label class="block font-medium mb-1">Dari</label>
        <select name="dari" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
            <option value="">-- Pilih Dari --</option>
            <option value="Kepala Dinas Pendidikan Provinsi Kepulauan Bangka Belitung" {{ old('dari', $suratNodin->dari ?? '') == 'Kepala Dinas Pendidikan Provinsi Kepulauan Bangka Belitung' ? 'selected' : '' }}>Kepala Dinas Pendidikan Provinsi Kepulauan Bangka Belitung</option>
            <option value="Kepala SMK Negeri 1 Koba" {{ old('dari', $suratNodin->dari ?? '') == 'Kepala SMK Negeri 1 Koba' ? 'selected' : '' }}>Kepala SMK Negeri 1 Koba</option>
        </select>
        <div class="mt-2">
            <label class="inline-flex items-center">
                <input type="checkbox" name="dari_plt" value="1" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" {{ old('dari_plt', $suratNodin->dari_plt ?? false) ? 'checked' : '' }}>
                <span class="ml-2 text-sm text-gray-600">Plt (Pelaksana Tugas)</span>
            </label>
            <label class="inline-flex items-center ml-4">
                <input type="checkbox" name="dari_an" value="1" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" {{ old('dari_an', $suratNodin->dari_an ?? false) ? 'checked' : '' }}>
                <span class="ml-2 text-sm text-gray-600">a.n (Atas Nama)</span>
            </label>
        </div>
    </div>

    <div>
        <label class="block font-medium mb-1">Tanggal</label>
        <input type="date" name="tanggal" value="{{ old('tanggal', optional($suratNodin->tanggal ?? null)->format('Y-m-d')) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>

    <div class="md:col-span-2">
        <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Isi Surat</h2>
    </div>

    <div class="md:col-span-2">
        <label class="block font-medium mb-1">Dasar Surat</label>
        <textarea name="dasar_surat" rows="4" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">{{ old('dasar_surat', $suratNodin->dasar_surat ?? '') }}</textarea>
    </div>

    <div class="md:col-span-2">
        <label class="block font-medium mb-1">Isi Surat</label>
        <textarea name="isi_surat" rows="4" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">{{ old('isi_surat', $suratNodin->isi_surat ?? '') }}</textarea>
    </div>

    <div class="md:col-span-2">
        <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Peserta</h2>
    </div>

    <div class="md:col-span-2">
        <label class="block font-medium mb-1">Kop Surat</label>
        <select name="kop_surat" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
            <option value="">-- Pilih Kop Surat --</option>
            @foreach($logos as $logo)
                <option value="{{ $logo->name }}" {{ old('kop_surat', $suratNodin->kop_surat ?? '') == $logo->name ? 'selected' : '' }}>
                    {{ $logo->name ?: 'Tanpa Nama' }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="md:col-span-2">
        <div class="flex justify-between items-center mb-2">
            <h2 class="text-lg font-semibold border-b pb-2">Daftar Peserta</h2>
            <button type="button" id="tambah-peserta" class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-bold py-1 px-3 rounded">+ Tambah Peserta</button>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto border">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-2 py-2 text-left">Pegawai</th>
                        <th class="px-2 py-2 text-left">Siswa</th>
                        <th class="px-2 py-2 text-left">Tgl Awal Kegiatan</th>
                        <th class="px-2 py-2 text-left">Tgl Akhir Kegiatan</th>
                        <th class="px-2 py-2 text-left">Tempat Kegiatan</th>
                        <th class="px-2 py-2 text-left"></th>
                    </tr>
                </thead>
                <tbody class="peserta-list">
                    @if(old('peserta') && is_array(old('peserta')))
                        @foreach(old('peserta') as $item)
                            @include('surat_nodins._peserta_row', ['index' => $pesertaIndex++, 'item' => $item, 'asns' => $asns, 'siswas' => $siswas])
                        @endforeach
                    @elseif(isset($suratNodin) && $suratNodin->pesertaSuratUsulans->count() > 0)
                        @php
                            $groupedPeserta = [];
                            foreach ($suratNodin->pesertaSuratUsulans as $peserta) {
                                $key = ($peserta->tgl_awal_kegiatan ?? '') . '|' . ($peserta->tgl_akhir_kegiatan ?? '') . '|' . ($peserta->tempat_kegiatan ?? '') . '|' . ($peserta->siswa_id ?? '');
                                if (!isset($groupedPeserta[$key])) {
                                    $groupedPeserta[$key] = [
                                        'pegawai_ids' => [],
                                        'siswa_id' => $peserta->siswa_id ?? '',
                                        'tgl_awal' => $peserta->tgl_awal_kegiatan ? \Carbon\Carbon::parse($peserta->tgl_awal_kegiatan)->format('Y-m-d') : '',
                                        'tgl_akhir' => $peserta->tgl_akhir_kegiatan ? \Carbon\Carbon::parse($peserta->tgl_akhir_kegiatan)->format('Y-m-d') : '',
                                        'tempat_kegiatan' => $peserta->tempat_kegiatan ?? '',
                                    ];
                                }
                                if ($peserta->pegawai_id) {
                                    $groupedPeserta[$key]['pegawai_ids'][] = $peserta->pegawai_id;
                                }
                            }
                        @endphp
                        @foreach($groupedPeserta as $group)
                            @php
                                $pegawaiIds = array_values(array_unique($group['pegawai_ids']));
                            @endphp
                            @include('surat_nodins._peserta_row', ['index' => $pesertaIndex++, 'item' => ['pegawai_id' => $pegawaiIds, 'siswa_id' => $group['siswa_id'], 'tgl_awal_kegiatan' => $group['tgl_awal'], 'tgl_akhir_kegiatan' => $group['tgl_akhir'], 'tempat_kegiatan' => $group['tempat_kegiatan']], 'asns' => $asns, 'siswas' => $siswas])
                        @endforeach
                    @endif
                    @if($pesertaIndex == 0)
                        @include('surat_nodins._peserta_row', ['index' => 0, 'item' => ['pegawai_id' => '', 'siswa_id' => '', 'tanggal_kegiatan' => '', 'tempat_kegiatan' => ''], 'asns' => $asns, 'siswas' => $siswas])
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <table style="display:none;">
        <tbody id="peserta-template">
            @include('surat_nodins._peserta_row', ['index' => '__INDEX__', 'item' => ['pegawai_id' => '', 'siswa_id' => '', 'tanggal_kegiatan' => '', 'tempat_kegiatan' => ''], 'asns' => $asns, 'siswas' => $siswas])
        </tbody>
    </table>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const list = document.querySelector('.peserta-list');
        const templateRow = document.querySelector('#peserta-template tr');
        const btnTambah = document.getElementById('tambah-peserta');

        function nextIndex() {
            return list.querySelectorAll('tr.peserta-row').length;
        }

        function initPegawaiSelect2(select) {
            if (typeof $ !== 'undefined') {
                $(select).select2({
                    placeholder: '-- Pilih Pegawai --',
                    allowClear: true,
                    width: '100%'
                });
            }
        }

        list.querySelectorAll('.pegawai-select2').forEach(initPegawaiSelect2);

        btnTambah.addEventListener('click', function () {
            const clone = templateRow.cloneNode(true);
            const index = nextIndex();
            clone.querySelectorAll('input, select, textarea').forEach(function(el) {
                if (el.name) {
                    el.name = el.name.replace('__INDEX__', index);
                }
                if (el.tagName === 'INPUT' && (el.type === 'text' || el.type === 'date')) {
                    el.value = '';
                }
                if (el.tagName === 'TEXTAREA') {
                    el.value = '';
                }
                if (el.classList.contains('pegawai-select2')) {
                    el.value = '';
                }
            });
            list.appendChild(clone);
            clone.querySelectorAll('.pegawai-select2').forEach(initPegawaiSelect2);
        });

        list.addEventListener('click', function (e) {
            if (e.target.closest('.hapus-peserta')) {
                const row = e.target.closest('tr.peserta-row');
                row.querySelectorAll('.pegawai-select2').forEach(function(select) {
                    if (typeof $ !== 'undefined') {
                        $(select).select2('destroy');
                    }
                });
                row.remove();
            }
        });
    });
    </script>

    <div class="md:col-span-2">
        <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Penandatangan</h2>
    </div>

    <div class="md:col-span-2">
        <label class="block font-medium mb-1">Pilih Penandatangan</label>
        <select name="penandatangan_id" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
            <option value="">-- Pilih Penandatangan --</option>
            @foreach($asns as $asn)
                <option value="{{ $asn->id }}" {{ old('penandatangan_id', $suratNodin->penandatangan_id ?? $defaultPenandatanganId) == $asn->id ? 'selected' : '' }}>
                    {{ $asn->nama }} {{ $asn->nip ? '(' . $asn->nip . ')' : '' }}
                </option>
            @endforeach
        </select>
        <div class="mt-2">
            <label class="inline-flex items-center">
                <input type="checkbox" name="penandatangan_plt" value="1" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" {{ old('penandatangan_plt', $suratNodin->penandatangan_plt ?? false) ? 'checked' : '' }}>
                <span class="ml-2 text-sm text-gray-600">Plt (Pelaksana Tugas)</span>
            </label>
            <label class="inline-flex items-center ml-4">
                <input type="checkbox" name="penandatangan_an" value="1" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" {{ old('penandatangan_an', $suratNodin->penandatangan_an ?? false) ? 'checked' : '' }}>
                <span class="ml-2 text-sm text-gray-600">a.n (Atas Nama)</span>
            </label>
        </div>
    </div>

    <div class="md:col-span-2">
        <label class="block font-medium mb-1">Pilih Pegawai Yang Diberi Tugas</label>
        <select name="pegawai_tugas_id" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
            <option value="">-- Pilih Pegawai Tugas --</option>
            @foreach($asns as $asn)
                <option value="{{ $asn->id }}" {{ old('pegawai_tugas_id', $suratNodin->pegawai_tugas_id ?? '') == $asn->id ? 'selected' : '' }}>
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
        <input type="text" name="tempat_ditetapkan" value="{{ old('tempat_ditetapkan', $suratNodin->tempat_ditetapkan ?? 'Koba') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>
    <div>
        <label class="block font-medium mb-1">Tanggal Ditetapkan</label>
        <input type="date" name="tanggal_ditetapkan" value="{{ old('tanggal_ditetapkan', optional($suratNodin->tanggal_ditetapkan ?? null)->format('Y-m-d')) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>
</div>


