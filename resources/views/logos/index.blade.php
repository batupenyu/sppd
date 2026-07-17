@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold">Logo Instansi</h1>
                    <a href="{{ route('logos.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Tambah Logo
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
                                <th class="px-4 py-2 text-left">Preview</th>
                                <th class="px-4 py-2 text-left">Nama</th>
                                <th class="px-4 py-2 text-left">Tipe</th>
                                <th class="px-4 py-2 text-left">ID</th>
                                <th class="px-4 py-2 text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                            @forelse($logos as $logo)
                            <tr>
                                <td class="px-4 py-2">
                                    @if($logo->image)
                                        <img src="{{ route('logos.image', $logo) }}" alt="{{ $logo->name }}" class="h-12 w-12 object-contain border rounded">
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2">{{ $logo->name }}</td>
                                <td class="px-4 py-2">{{ $logo->mime ?: '-' }}</td>
                                <td class="px-4 py-2">{{ $logo->id }}</td>
                                <td class="px-4 py-2">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('logos.edit', $logo) }}" class="text-yellow-600 hover:text-yellow-800" title="Edit">Edit</a>
                                        <form action="{{ route('logos.destroy', $logo) }}" method="POST" class="inline" onsubmit="return confirm('Hapus logo ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800" title="Hapus">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-4 py-2 text-center">Belum ada logo.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $logos->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
