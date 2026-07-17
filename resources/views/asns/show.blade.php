@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold">Detail Data ASN</h1>
                    <div>
                        <a href="{{ route('asns.edit', $asn) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded mr-2">Edit</a>
                        <a href="{{ route('asns.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Kembali</a>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <h2 class="text-lg font-semibold mb-4 border-b pb-2">Data Pribadi</h2>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-500">Nama</span>
                        <span class="text-gray-900 dark:text-gray-100">{{ $asn->nama }}</span>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-500">NUPTK</span>
                        <span class="text-gray-900 dark:text-gray-100">{{ $asn->nuptk }}</span>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-500">Jenis Kelamin</span>
                        <span class="text-gray-900 dark:text-gray-100">{{ $asn->jk == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-500">Tempat Lahir</span>
                        <span class="text-gray-900 dark:text-gray-100">{{ $asn->tempat_lahir }}</span>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-500">Tanggal Lahir</span>
                        <span class="text-gray-900 dark:text-gray-100">{{ $asn->tanggal_lahir ? \Carbon\Carbon::parse($asn->tanggal_lahir)->format('d-m-Y') : '-' }}</span>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-500">NIP</span>
                        <span class="text-gray-900 dark:text-gray-100">{{ $asn->nip }}</span>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-500">Status Kepegawaian</span>
                        <span class="text-gray-900 dark:text-gray-100">{{ $asn->status_kepegawaian }}</span>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-500">Jenis PTK</span>
                        <span class="text-gray-900 dark:text-gray-100">{{ $asn->jenis_ptk }}</span>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-500">Agama</span>
                        <span class="text-gray-900 dark:text-gray-100">{{ $asn->agama }}</span>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-500">NIK</span>
                        <span class="text-gray-900 dark:text-gray-100">{{ $asn->nik }}</span>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-500">No KK</span>
                        <span class="text-gray-900 dark:text-gray-100">{{ $asn->no_kk }}</span>
                    </div>

                    <div class="md:col-span-2">
                        <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Alamat</h2>
                    </div>

                    <div class="md:col-span-2">
                        <span class="block text-sm font-medium text-gray-500">Alamat Jalan</span>
                        <span class="text-gray-900 dark:text-gray-100">{{ $asn->alamat_jalan }}</span>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-500">RT</span>
                        <span class="text-gray-900 dark:text-gray-100">{{ $asn->rt }}</span>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-500">RW</span>
                        <span class="text-gray-900 dark:text-gray-100">{{ $asn->rw }}</span>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-500">Nama Dusun</span>
                        <span class="text-gray-900 dark:text-gray-100">{{ $asn->nama_dusun }}</span>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-500">Desa/Kelurahan</span>
                        <span class="text-gray-900 dark:text-gray-100">{{ $asn->desa_kelurahan }}</span>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-500">Kecamatan</span>
                        <span class="text-gray-900 dark:text-gray-100">{{ $asn->kecamatan }}</span>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-500">Kode Pos</span>
                        <span class="text-gray-900 dark:text-gray-100">{{ $asn->kode_pos }}</span>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-500">Telepon</span>
                        <span class="text-gray-900 dark:text-gray-100">{{ $asn->telepon }}</span>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-500">HP</span>
                        <span class="text-gray-900 dark:text-gray-100">{{ $asn->hp }}</span>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-500">Email</span>
                        <span class="text-gray-900 dark:text-gray-100">{{ $asn->email }}</span>
                    </div>

                    <div class="md:col-span-2">
                        <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Kepegawaian</h2>
                    </div>

                    <div class="md:col-span-2">
                        <span class="block text-sm font-medium text-gray-500">Tugas Tambahan</span>
                        <span class="text-gray-900 dark:text-gray-100">{{ $asn->tugas_tambahan }}</span>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-500">SK CPNS</span>
                        <span class="text-gray-900 dark:text-gray-100">{{ $asn->sk_cpns }}</span>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-500">Tanggal CPNS</span>
                        <span class="text-gray-900 dark:text-gray-100">{{ $asn->tanggal_cpns ? \Carbon\Carbon::parse($asn->tanggal_cpns)->format('d-m-Y') : '-' }}</span>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-500">SK Pengangkatan</span>
                        <span class="text-gray-900 dark:text-gray-100">{{ $asn->sk_pengangkatan }}</span>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-500">TMT Pengangkatan</span>
                        <span class="text-gray-900 dark:text-gray-100">{{ $asn->tmt_pengangkatan ? \Carbon\Carbon::parse($asn->tmt_pengangkatan)->format('d-m-Y') : '-' }}</span>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-500">Lembaga Pengangkatan</span>
                        <span class="text-gray-900 dark:text-gray-100">{{ $asn->lembaga_pengangkatan }}</span>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-500">Pangkat Golongan</span>
                        <span class="text-gray-900 dark:text-gray-100">{{ $asn->pangkat_golongan }}</span>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-500">Sumber Gaji</span>
                        <span class="text-gray-900 dark:text-gray-100">{{ $asn->sumber_gaji }}</span>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-500">TMT PNS</span>
                        <span class="text-gray-900 dark:text-gray-100">{{ $asn->tmt_pns ? \Carbon\Carbon::parse($asn->tmt_pns)->format('d-m-Y') : '-' }}</span>
                    </div>

                    <div class="md:col-span-2">
                        <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Keluarga</h2>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-500">Nama Ibu Kandung</span>
                        <span class="text-gray-900 dark:text-gray-100">{{ $asn->nama_ibu_kandung }}</span>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-500">Status Perkawinan</span>
                        <span class="text-gray-900 dark:text-gray-100">{{ $asn->status_perkawinan }}</span>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-500">Nama Suami/Istri</span>
                        <span class="text-gray-900 dark:text-gray-100">{{ $asn->nama_suami_istri }}</span>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-500">NIP Suami/Istri</span>
                        <span class="text-gray-900 dark:text-gray-100">{{ $asn->nip_suami_istri }}</span>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-500">Pekerjaan Suami/Istri</span>
                        <span class="text-gray-900 dark:text-gray-100">{{ $asn->pekerjaan_suami_istri }}</span>
                    </div>

                    <div class="md:col-span-2">
                        <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Keahlian</h2>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-500">Sudah Lisensi Kepala Sekolah</span>
                        <span class="text-gray-900 dark:text-gray-100">{{ $asn->sudah_lisensi_kepala_sekolah }}</span>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-500">Pernah Diklat Kepengawasan</span>
                        <span class="text-gray-900 dark:text-gray-100">{{ $asn->pernah_diklat_kepengawasan }}</span>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-500">Keahlian Braille</span>
                        <span class="text-gray-900 dark:text-gray-100">{{ $asn->keahlian_braille }}</span>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-500">Keahlian Bahasa Isyarat</span>
                        <span class="text-gray-900 dark:text-gray-100">{{ $asn->keahlian_bahasa_isyarat }}</span>
                    </div>

                    <div class="md:col-span-2">
                        <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Pajak & Keuangan</h2>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-500">NPWP</span>
                        <span class="text-gray-900 dark:text-gray-100">{{ $asn->npwp }}</span>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-500">Nama Wajib Pajak</span>
                        <span class="text-gray-900 dark:text-gray-100">{{ $asn->nama_wajib_pajak }}</span>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-500">Kewarganegaraan</span>
                        <span class="text-gray-900 dark:text-gray-100">{{ $asn->kewarganegaraan }}</span>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-500">Bank</span>
                        <span class="text-gray-900 dark:text-gray-100">{{ $asn->bank }}</span>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-500">Nomor Rekening Bank</span>
                        <span class="text-gray-900 dark:text-gray-100">{{ $asn->nomor_rekening_bank }}</span>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-500">Rekening Atas Nama</span>
                        <span class="text-gray-900 dark:text-gray-100">{{ $asn->rekening_atas_nama }}</span>
                    </div>

                    <div class="md:col-span-2">
                        <h2 class="text-lg font-semibold mb-4 border-b pb-2 mt-4">Lainnya</h2>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-500">Karpeg</span>
                        <span class="text-gray-900 dark:text-gray-100">{{ $asn->karpeg }}</span>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-500">Karis/Karsu</span>
                        <span class="text-gray-900 dark:text-gray-100">{{ $asn->karis_karsu }}</span>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-500">Lintang</span>
                        <span class="text-gray-900 dark:text-gray-100">{{ $asn->lintang }}</span>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-500">Bujur</span>
                        <span class="text-gray-900 dark:text-gray-100">{{ $asn->bujur }}</span>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-500">NUKS</span>
                        <span class="text-gray-900 dark:text-gray-100">{{ $asn->nuks }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
