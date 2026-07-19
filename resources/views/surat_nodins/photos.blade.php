@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold">Foto Lampiran - {{ $suratNodin->nomor ?: 'Tanpa Nomor' }}</h1>
                    <a href="{{ route('surat-nodins.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Kembali</a>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    @forelse($suratNodin->photos as $photo)
                        <div class="border rounded overflow-hidden">
                            @php
                                $src = $photo->image ? 'data:' . ($photo->mime ?: 'image/png') . ';base64,' . base64_encode($photo->image) : '';
                            @endphp
                            @if($src)
                                <img src="{{ $src }}" alt="{{ $photo->caption ?: 'Foto' }}" class="w-full h-48 object-cover" />
                            @endif
                            <div class="p-3">
                                <p class="text-sm mb-2">{{ $photo->caption ?: '-' }}</p>
                                <div class="flex gap-2">
                                    <a href="{{ route('surat-nodins.photos.edit', [$suratNodin, $photo]) }}" class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800 hover:bg-yellow-200">Ubah</a>
                                    <form action="{{ route('surat-nodins.photos.destroy', [$suratNodin, $photo]) }}" method="POST" class="inline" onsubmit="return confirm('Hapus foto ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium rounded-full bg-red-100 text-red-800 hover:bg-red-200">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="md:col-span-3 text-center text-gray-500 py-8">
                            Belum ada foto lampiran.
                        </div>
                    @endforelse
                </div>

                <div class="border-t pt-6">
                    <h2 class="text-lg font-semibold mb-4">Tambah Foto Baru</h2>
                    <form action="{{ route('surat-nodins.photos.store', $suratNodin) }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @csrf
                        <div>
                            <label class="block font-medium mb-1">Pilih Foto (bisa lebih dari satu kali submit)</label>
                            <input type="file" name="photo" accept="image/*" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100" required>
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Keterangan</label>
                            <input type="text" name="caption" value="{{ old('caption') }}" placeholder="cth: Dokumentasi Kegiatan" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        </div>
                        <div class="md:col-span-2">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Upload Foto</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
