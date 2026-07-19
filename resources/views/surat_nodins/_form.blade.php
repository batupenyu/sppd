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
        <input type="text" name="nomor" value="{{ old('nomor', $suratNodin->nomor ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>

    <div>
        <label class="block font-medium mb-1">Sifat</label>
        <input type="text" name="sifat" value="{{ old('sifat', $suratNodin->sifat ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>

    <div>
        <label class="block font-medium mb-1">Lampiran</label>
        <input type="text" name="lampiran" value="{{ old('lampiran', $suratNodin->lampiran ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>

    <div>
        <label class="block font-medium mb-1">Hal</label>
        <input type="text" name="hal" value="{{ old('hal', $suratNodin->hal ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>

    <div class="md:col-span-2">
        <label class="block font-medium mb-1">Yth.</label>
        <input type="text" name="kepada" value="{{ old('kepada', $suratNodin->kepada ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>

    <div class="md:col-span-2">
        <label class="block font-medium mb-1">Dari</label>
        <input type="text" name="dari" value="{{ old('dari', $suratNodin->dari ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
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
        <textarea name="dasar_surat" rows="3" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">{{ old('dasar_surat', $suratNodin->dasar_surat ?? '') }}</textarea>
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
                        <th class="px-2 py-2 text-left">Tanggal Kegiatan</th>
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
                        @foreach($suratNodin->pesertaSuratUsulans as $peserta)
                            @php
                                $pegawaiId = $peserta->pegawai_id ?? '';
                                $siswaId = $peserta->siswa_id ?? '';
                                $tanggalKegiatan = $peserta->tanggal_kegiatan ? \Carbon\Carbon::parse($peserta->tanggal_kegiatan)->format('Y-m-d') : '';
                                $tempatKegiatan = $peserta->tempat_kegiatan ?? '';
                            @endphp
                            @include('surat_nodins._peserta_row', ['index' => $pesertaIndex++, 'item' => ['pegawai_id' => $pegawaiId, 'siswa_id' => $siswaId, 'tanggal_kegiatan' => $tanggalKegiatan, 'tempat_kegiatan' => $tempatKegiatan], 'asns' => $asns, 'siswas' => $siswas])
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

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const list = document.querySelector('.peserta-list');
        const templateRow = document.querySelector('#peserta-template tr');
        const btnTambah = document.getElementById('tambah-peserta');

        function nextIndex() {
            return list.querySelectorAll('tr.peserta-row').length;
        }

        btnTambah.addEventListener('click', function () {
            const clone = templateRow.cloneNode(true);
            const index = nextIndex();
            clone.querySelectorAll('input, select').forEach(function(el) {
                if (el.name) {
                    el.name = el.name.replace('__INDEX__', index);
                }
                if (el.tagName === 'INPUT' && (el.type === 'text' || el.type === 'date')) {
                    el.value = '';
                }
            });
            list.appendChild(clone);
        });

        list.addEventListener('click', function (e) {
            if (e.target.closest('.hapus-peserta')) {
                e.target.closest('tr.peserta-row').remove();
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
    </div>

    <div class="md:col-span-2">
        <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Penetapan</h2>
    </div>

    <div>
        <label class="block font-medium mb-1">Tempat Ditetapkan</label>
        <input type="text" name="tempat_ditetapkan" value="{{ old('tempat_ditetapkan', $suratNodin->tempat_ditetapkan ?? '') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>
    <div>
        <label class="block font-medium mb-1">Tanggal Ditetapkan</label>
        <input type="date" name="tanggal_ditetapkan" value="{{ old('tanggal_ditetapkan', optional($suratNodin->tanggal_ditetapkan ?? null)->format('Y-m-d')) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
    </div>
</div>


