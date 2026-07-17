@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold">Import Data ASN dari CSV</h1>
                    <a href="{{ route('asns.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Kembali
                    </a>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {!! session('success') !!}
                    </div>
                @endif

                <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
                    <p class="text-sm text-blue-700">
                        <strong>Petunjuk Import:</strong><br>
                        1. Download template CSV dengan menekan tombol Export CSV di halaman Data ASN.<br>
                        2. Isi data sesuai format kolom yang ada (maksimal 50 kolom).<br>
                        3. Upload file CSV yang sudah diisi.<br>
                        4. Sistem akan memproses setiap baris data.
                    </p>
                </div>

                <form action="{{ route('asns.import.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-6">
                        <label class="block font-medium mb-2">Pilih File CSV</label>
                        <input type="file" name="file" accept=".csv,.txt" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100" required>
                        @error('file')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex gap-4">
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Import Data
                        </button>
                        <a href="{{ route('asns.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
