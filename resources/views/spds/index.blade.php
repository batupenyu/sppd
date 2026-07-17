@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold">Surat Perjalanan Dinas (SPD)</h1>
                    <a href="{{ route('asns.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Data ASN
                    </a>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-2 text-left">Nomor</th>
                                <th class="px-4 py-2 text-left">Nama Pegawai</th>
                                <th class="px-4 py-2 text-left">Maksud Perjalanan</th>
                                <th class="px-4 py-2 text-left">Tujuan</th>
                                <th class="px-4 py-2 text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                            @forelse($spds as $spd)
                            <tr>
                                <td class="px-4 py-2">{{ $spd->nomor ?: '-' }}</td>
                                <td class="px-4 py-2">{{ $spd->nama }}</td>
                                <td class="px-4 py-2">{{ $spd->maksud_perjalanan }}</td>
                                <td class="px-4 py-2">{{ $spd->tempat_tujuan }}</td>
                                <td class="px-4 py-2">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('spds.print', $spd) }}" class="text-blue-600 hover:text-blue-800" title="Cetak">Cetak</a>
                                        <a href="{{ route('spds.edit', $spd) }}" class="text-yellow-600 hover:text-yellow-800" title="Edit">Edit</a>
                                        <form action="{{ route('spds.destroy', $spd) }}" method="POST" class="inline" onsubmit="return confirm('Hapus SPD ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800" title="Hapus">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-4 py-2 text-center">Belum ada data SPD.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    <a href="{{ route('spds.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Buat SPD Baru
                    </a>
                </div>

                <div class="mt-4">
                    {{ $spds->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
