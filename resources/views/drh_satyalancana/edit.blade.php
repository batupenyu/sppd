@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h1 class="text-2xl font-bold mb-6">Edit Daftar Riwayat Hidup - Satyalancana</h1>

                <form action="{{ route('drh-satyalancana.update', $drh) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block font-medium mb-1">Pegawai (ASN) *</label>
                            <select name="asn_id" id="asn_select" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100" required>
                                <option value="">-- Pilih Pegawai --</option>
                                @foreach($asns as $asn)
                                    <option value="{{ $asn->id }}"
                                        data-pendidikan="{{ $asn->pendidikan_terakhir ?: '' }}"
                                        data-pangkat="{{ $asn->pangkat_golongan ?: '' }}"
                                        data-tmt-pangkat="{{ $asn->tmt_pangkat ?: '' }}"
                                        data-no-sk-cpns="{{ $asn->sk_cpns ?: '' }}"
                                        data-tmt-cpns="{{ $asn->tmt_pengangkatan ?: '' }}"
                                        data-jabatan="{{ $asn->tugas_tambahan ?: ($asn->jenis_ptk ?: '') }}"
                                        data-tmt-jabatan="{{ $asn->tmt_jabatan ?: '' }}"
                                        {{ (old('asn_id', $drh->asn_id) == $asn->id) ? 'selected' : '' }}>
                                        {{ $asn->nama }} {{ $asn->nip ? '(' . $asn->nip . ')' : '' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('asn_id')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label class="block font-medium mb-1">NIP Lama (jika ada)</label>
                            <input type="text" name="nip_lama" value="{{ old('nip_lama', $drh->nip_lama) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Pendidikan Terakhir</label>
                            <input type="text" name="pendidikan_terakhir" value="{{ old('pendidikan_terakhir', $drh->pendidikan_terakhir) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Pangkat, Gol. Ruang Terakhir</label>
                            <input type="text" name="pangkat" value="{{ old('pangkat', $drh->pangkat) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>

                        <div>
                            <label class="block font-medium mb-1">TMT Pangkat</label>
                            <input type="date" name="tmt_pangkat" value="{{ old('tmt_pangkat', $drh->tmt_pangkat) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>

                        <div>
                            <label class="block font-medium mb-1">No. SK CPNS</label>
                            <input type="text" name="no_sk_cpns" value="{{ old('no_sk_cpns', $drh->no_sk_cpns) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>

                        <div>
                            <label class="block font-medium mb-1">TMT CPNS</label>
                            <input type="date" name="tmt_cpns" value="{{ old('tmt_cpns', $drh->tmt_cpns) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Jabatan Terakhir</label>
                            <input type="text" name="jabatan_terakhir" value="{{ old('jabatan_terakhir', $drh->jabatan_terakhir) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>

                        <div>
                            <label class="block font-medium mb-1">TMT Jabatan</label>
                            <input type="date" name="tmt_jabatan" value="{{ old('tmt_jabatan', $drh->tmt_jabatan) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Tanda Kehormatan (ke-berapa)</label>
                            <input type="text" name="tanda_kehormatan" value="{{ old('tanda_kehormatan', $drh->tanda_kehormatan) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Tanggal Keppres</label>
                            <input type="date" name="tgl_kepres" value="{{ old('tgl_kepres', $drh->tgl_kepres) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>

                        <div>
                            <label class="block font-medium mb-1">No. Keppres</label>
                            <input type="text" name="no_kepres" value="{{ old('no_kepres', $drh->no_kepres) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block font-medium mb-1">Hukuman Disiplin</label>
                            <textarea name="hukuman_disiplin" rows="2" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">{{ old('hukuman_disiplin', $drh->hukuman_disiplin) }}</textarea>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block font-medium mb-1">CLTN</label>
                            <textarea name="cltn" rows="2" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">{{ old('cltn', $drh->cltn) }}</textarea>
                        </div>

                        <div class="md:col-span-2">
                            <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-2">Atasan Langsung</h2>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block font-medium mb-1">Pilih Atasan Langsung dari Data Pegawai</label>
                            <select id="atasan_select" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                                <option value="">-- Pilih Pegawai --</option>
                                @foreach($asns as $asn)
                                    <option value="{{ $asn->id }}"
                                        data-nama="{{ $asn->nama }}"
                                        data-nip="{{ $asn->nip ?: '' }}">
                                        {{ $asn->nama }} {{ $asn->nip ? '(' . $asn->nip . ')' : '' }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-sm text-gray-500 mt-1">Pilih pegawai, lalu nama & NIP atasan akan terisi otomatis (masih bisa diedit).</p>
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Nama Atasan Langsung</label>
                            <input type="text" name="atasan_nama" id="atasan_nama" value="{{ old('atasan_nama', $drh->atasan_nama) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>

                        <div>
                            <label class="block font-medium mb-1">NIP Atasan Langsung</label>
                            <input type="text" name="atasan_nip" id="atasan_nip" value="{{ old('atasan_nip', $drh->atasan_nip) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>
                    </div>

                    <div class="mt-6 flex gap-4">
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Simpan & Cetak</button>
                        <a href="{{ route('drh-satyalancana.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

                    <script>
                        document.getElementById('asn_select').addEventListener('change', function () {
                            const opt = this.options[this.selectedIndex];
                            const set = (name, val) => {
                                const el = document.querySelector('[name="' + name + '"]');
                                if (el) {
                                    el.value = val || '';
                                }
                            };

                            set('pendidikan_terakhir', opt.dataset.pendidikan);
                            set('pangkat', opt.dataset.pangkat);
                            set('tmt_pangkat', opt.dataset.tmtPangkat);
                            set('no_sk_cpns', opt.dataset.noSkCpns);
                            set('tmt_cpns', opt.dataset.tmtCpns);
                            set('jabatan_terakhir', opt.dataset.jabatan);
                            set('tmt_jabatan', opt.dataset.tmtJabatan);
                        });

                        document.getElementById('atasan_select').addEventListener('change', function () {
                            const opt = this.options[this.selectedIndex];
                            document.getElementById('atasan_nama').value = opt.dataset.nama || '';
                            document.getElementById('atasan_nip').value = opt.dataset.nip || '';
                        });
                    </script>
@endsection
