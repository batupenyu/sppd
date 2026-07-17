@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h1 class="text-2xl font-bold mb-6">Edit Logo</h1>

                <form action="{{ route('logos.update', $logo) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Nama *</label>
                        <input type="text" name="name" value="{{ old('name', $logo->name) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100" required>
                        @error('name')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Preview</label>
                        @if($logo->image)
                            <img src="{{ route('logos.image', $logo) }}" alt="{{ $logo->name }}" class="h-20 w-20 object-contain border rounded mb-2">
                        @else
                            <p class="text-gray-400 mb-2">Tidak ada gambar</p>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Ganti File Gambar (kosongkan jika tidak diubah)</label>
                        <input type="file" name="image" accept="image/*" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        @error('image')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <div class="mt-6 flex gap-4">
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Simpan</button>
                        <a href="{{ route('logos.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
