<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - CRUD ASN</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-gray-50 dark:bg-gray-900">
        <nav class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center gap-4">
                        <a href="{{ route('asns.index') }}" class="text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">Data ASN</a>
                        <a href="{{ route('spds.index') }}" class="text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">SPD</a>
                        <a href="{{ route('logos.index') }}" class="text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">Logo</a>
                        <a href="{{ route('surat-tugas.index') }}" class="text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">Surat Tugas</a>
                        <a href="{{ route('drh-satyalancana.index') }}" class="text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">DRH Satyalancana</a>
                        <a href="{{ route('sptjms.index') }}" class="text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">SPTJM</a>
                        <a href="{{ route('spmts.index') }}" class="text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">SPMT</a>
                        <a href="{{ route('surat-cutis.index') }}" class="text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">Surat Cuti</a>
                    </div>
                </div>
            </div>
        </nav>

        <main>
            @yield('content')
        </main>
    </body>
</html>
