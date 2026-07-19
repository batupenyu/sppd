@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold">Edit Foto Lampiran</h1>
                    <a href="{{ route('surat-nodins.photos', $suratNodin) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Kembali</a>
                </div>

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
                        <img src="{{ $src }}" alt="{{ $photo->caption ?: 'Foto' }}" class="max-w-full max-h-96 border rounded" />
                    </div>
                @endif

                <form action="{{ route('surat-nodins.photos.update', [$suratNodin, $photo]) }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 gap-4">
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
                    <div>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Perbarui Foto</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
