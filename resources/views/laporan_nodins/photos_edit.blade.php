@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h1 class="text-2xl font-bold mb-6">Ubah Foto Lampiran - {{ $laporanNodin->nomor ?: 'Tanpa Nomor' }}</h1>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @php
                    $src = $photo->image ? 'data:' . ($photo->mime ?: 'image/png') . ';base64,' . base64_encode($photo->image) : '';
                @endphp
                @if($src)
                    <div class="mb-6">
                        <img src="{{ $src }}" alt="{{ $photo->caption ?: 'Foto' }}" class="w-full max-h-96 object-contain border rounded" />
                    </div>
                @endif

                <form action="{{ route('laporan-nodins.photos.update', [$laporanNodin, $photo]) }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 gap-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block font-medium mb-1">Ganti Foto (opsional)</label>
                        <input type="file" name="photo" accept="image/*" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                    </div>
                    <div>
                        <label class="block font-medium mb-1">Keterangan</label>
                        <input type="text" name="caption" value="{{ old('caption', $photo->caption) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Simpan Perubahan</button>
                        <a href="{{ route('laporan-nodins.photos', $laporanNodin) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
