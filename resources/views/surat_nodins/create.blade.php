@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h1 class="text-2xl font-bold mb-6">Buat Surat Nodin</h1>

                @if($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('surat-nodins.store') }}" method="POST">
                    @csrf

                    @include('surat_nodins._form')

                    <div class="mt-6 flex gap-4">
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Simpan & Cetak</button>
                        <a href="{{ route('surat-nodins.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.peserta-jenis').forEach(function(select) {
        togglePesertaFields(select);
        select.addEventListener('change', function() {
            togglePesertaFields(this);
        });
    });

    function togglePesertaFields(select) {
        const row = select.closest('.peserta-row');
        if (!row) return;
        const pegawaiField = row.querySelector('.pegawai-field');
        const siswaField = row.querySelector('.siswa-field');
        if (select.value === 'pegawai') {
            pegawaiField.classList.remove('hidden');
            siswaField.classList.add('hidden');
        } else {
            pegawaiField.classList.add('hidden');
            siswaField.classList.remove('hidden');
        }
    }
});
</script>
@endpush
