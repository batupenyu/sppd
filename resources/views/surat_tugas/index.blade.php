@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold">Surat Tugas</h1>
                    <a href="{{ route('surat-tugas.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Buat Surat Tugas
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
                                <th class="px-4 py-2 text-left">Peserta</th>
                                <th class="px-4 py-2 text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                            @forelse($suratTugas as $st)
                            <tr>
                                <td class="px-4 py-2">{{ $st->nomor ?: '-' }}</td>
                                <td class="px-4 py-2">
                                    @php
                                        $ids = $st->peserta ?? [];
                                        $names = \App\Models\Asn::whereIn('id', $ids)->pluck('nama')->all();
                                    @endphp
                                    {{ $names ? implode(', ', $names) : '-' }}
                                </td>
                                <td class="px-4 py-2">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('surat-tugas.print', $st) }}" class="text-blue-600 hover:text-blue-800" title="Cetak">Cetak</a>
                                        <a href="{{ route('surat-tugas.edit', $st) }}" class="text-yellow-600 hover:text-yellow-800" title="Edit">Edit</a>
                                        <form action="{{ route('surat-tugas.destroy', $st) }}" method="POST" class="inline" onsubmit="return confirm('Hapus surat tugas ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800" title="Hapus">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-4 py-2 text-center">Belum ada data Surat Tugas.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $suratTugas->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
