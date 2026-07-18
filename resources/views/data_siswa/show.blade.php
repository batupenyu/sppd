@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold">Detail Data Siswa</h1>
                    <div>
                        <a href="{{ route('data-siswa.edit', $siswa) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded mr-2">Edit</a>
                        <a href="{{ route('data-siswa.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Kembali</a>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <span class="block text-sm font-medium text-gray-500">Nama</span>
                        <span class="text-gray-900 dark:text-gray-100">{{ $siswa->nama }}</span>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-500">NISN</span>
                        <span class="text-gray-900 dark:text-gray-100">{{ $siswa->nisn }}</span>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-500">NIS</span>
                        <span class="text-gray-900 dark:text-gray-100">{{ $siswa->nis }}</span>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-500">Tanggal Lahir</span>
                        <span class="text-gray-900 dark:text-gray-100">{{ $siswa->tgl_lahir ? \Carbon\Carbon::parse($siswa->tgl_lahir)->format('d-m-Y') : '-' }}</span>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-500">Kelas</span>
                        <span class="text-gray-900 dark:text-gray-100">{{ $siswa->kelas }}</span>
                    </div>

                    <div class="md:col-span-2">
                        <span class="block text-sm font-medium text-gray-500">Alamat</span>
                        <span class="text-gray-900 dark:text-gray-100">{{ $siswa->alamat }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
