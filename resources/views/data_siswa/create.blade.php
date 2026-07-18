@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h1 class="text-2xl font-bold mb-6">Tambah Data Siswa</h1>

                <form action="{{ route('data-siswa.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block font-medium mb-1">Nama *</label>
                            <input type="text" name="nama" value="{{ old('nama') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100" required>
                            @error('nama')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label class="block font-medium mb-1">NISN</label>
                            <input type="text" name="nisn" value="{{ old('nisn') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                            @error('nisn')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label class="block font-medium mb-1">NIS</label>
                            <input type="text" name="nis" value="{{ old('nis') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                            @error('nis')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Tanggal Lahir</label>
                            <input type="date" name="tgl_lahir" value="{{ old('tgl_lahir') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                            @error('tgl_lahir')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Kelas</label>
                            <input type="text" name="kelas" value="{{ old('kelas') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                            @error('kelas')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block font-medium mb-1">Alamat</label>
                            <textarea name="alamat" rows="3" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">{{ old('alamat') }}</textarea>
                            @error('alamat')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="mt-6 flex gap-4">
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Simpan
                        </button>
                        <a href="{{ route('data-siswa.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
