<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - CRUD ASN</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            @media (min-width: 1024px) {
                .main-wrapper {
                    margin-left: 256px;
                }
            }
        </style>
    </head>
    <body class="bg-gray-50 dark:bg-gray-900">
        <div class="flex min-h-screen">
            <!-- Sidebar -->
            <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 transform -translate-x-full transition-transform duration-300 ease-in-out lg:translate-x-0 flex flex-col h-screen">
                <div class="flex items-center justify-between h-16 px-4 border-b border-gray-200 dark:border-gray-700">
                    <a href="{{ route('asns.index') }}" class="text-lg font-bold text-gray-800 dark:text-gray-100">Menu</a>
                    <button id="close-sidebar" class="lg:hidden p-2 rounded-md text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <nav class="p-4 space-y-1 overflow-y-auto flex-1 min-h-0">
                    <a href="{{ route('asns.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('asns.*') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : '' }}">
                        Data ASN
                    </a>
                    <a href="{{ route('data-siswa.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('data-siswa.*') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : '' }}">
                        Data Siswa
                    </a>
                    <a href="{{ route('spds.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('spds.*') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : '' }}">
                        SPD
                    </a>
                    <a href="{{ route('logos.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('logos.*') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : '' }}">
                        Logo
                    </a>
                    @php($isSuratActive = request()->is('surat-tugas*','drh-satyalancana*','sptjms*','spmts*','surat-cutis*','laporan-cutis*','surat-dispensasis*','surat-keterangans*','surat-kp4s*','surat-panggilan-siswas*','surat-pengantars*','surat-rekomendasis*','surat-resmis*','surat-santunans*','surat-umums*','surat-undangans*','surat-nodins*'))
                    <button type="button" id="surat-toggle" class="w-full flex items-center justify-between px-3 py-2 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 {{ $isSuratActive ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : '' }}">
                        <span>Surat &amp; Dokumen</span>
                        <svg id="surat-chevron" class="w-4 h-4 transition-transform {{ $isSuratActive ? 'rotate-180' : '' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div id="surat-submenu" class="ml-3 space-y-1 {{ $isSuratActive ? '' : 'hidden' }}">
                        <a href="{{ route('surat-tugas.index') }}" class="block px-3 py-2 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('surat-tugas.*') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : '' }}">
                            Surat Tugas
                        </a>
                        <a href="{{ route('drh-satyalancana.index') }}" class="block px-3 py-2 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('drh-satyalancana.*') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : '' }}">
                            DRH Satyalancana
                        </a>
                        <a href="{{ route('sptjms.index') }}" class="block px-3 py-2 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('sptjms.*') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : '' }}">
                            SPTJM
                        </a>
                        <a href="{{ route('spmts.index') }}" class="block px-3 py-2 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('spmts.*') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : '' }}">
                            SPMT
                        </a>
                        <a href="{{ route('surat-cutis.index') }}" class="block px-3 py-2 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('surat-cutis.*') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : '' }}">
                            Surat Cuti
                        </a>
                        <a href="{{ route('laporan-cutis.index') }}" class="block px-3 py-2 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('laporan-cutis.*') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : '' }}">
                            Laporan Cuti
                        </a>
                        <a href="{{ route('surat-dispensasis.index') }}" class="block px-3 py-2 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('surat-dispensasis.*') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : '' }}">
                            Surat Dispensasi
                        </a>
                        <a href="{{ route('surat-keterangans.index') }}" class="block px-3 py-2 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('surat-keterangans.*') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : '' }}">
                            Surat Keterangan
                        </a>
                        <a href="{{ route('surat-kp4s.index') }}" class="block px-3 py-2 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('surat-kp4s.*') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : '' }}">
                            Surat KP4
                        </a>
                        <a href="{{ route('surat-panggilan-siswas.index') }}" class="block px-3 py-2 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('surat-panggilan-siswas.*') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : '' }}">
                            Surat Panggilan Siswa
                        </a>
                        <a href="{{ route('surat-pengantars.index') }}" class="block px-3 py-2 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('surat-pengantars.*') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : '' }}">
                            Surat Pengantar
                        </a>
                        <a href="{{ route('surat-rekomendasis.index') }}" class="block px-3 py-2 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('surat-rekomendasis.*') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : '' }}">
                            Surat Rekomendasi
                        </a>
                        <a href="{{ route('surat-resmis.index') }}" class="block px-3 py-2 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('surat-resmis.*') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : '' }}">
                            Surat Resmi
                        </a>
                        <a href="{{ route('surat-santunans.index') }}" class="block px-3 py-2 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('surat-santunans.*') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : '' }}">
                            Surat Santunan
                        </a>
                        <a href="{{ route('surat-umums.index') }}" class="block px-3 py-2 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('surat-umums.*') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : '' }}">
                            Surat Umum
                        </a>
                        <a href="{{ route('surat-undangans.index') }}" class="block px-3 py-2 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('surat-undangans.*') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : '' }}">
                            Surat Undangan
                        </a>
                        <a href="{{ route('surat-nodins.index') }}" class="block px-3 py-2 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('surat-nodins.*') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : '' }}">
                            Surat Nodin
                        </a>
                    </div>
                </nav>
            </aside>

            <!-- Overlay -->
            <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden lg:hidden"></div>

            <!-- Main Content -->
            <div class="flex-1 flex flex-col min-w-0 main-wrapper">
                <!-- Top Header -->
                <header class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 h-16 flex items-center justify-between px-4">
                    <button id="open-sidebar" class="lg:hidden p-2 rounded-md text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        @yield('header-title', '')
                    </div>
                </header>

                <main class="flex-1 p-6">
                    @yield('content')
                </main>
            </div>
        </div>

        <script>
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            const openBtn = document.getElementById('open-sidebar');
            const closeBtn = document.getElementById('close-sidebar');

            function openSidebar() {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
            }

            function closeSidebar() {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            }

            openBtn.addEventListener('click', openSidebar);
            closeBtn.addEventListener('click', closeSidebar);
            overlay.addEventListener('click', closeSidebar);

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') closeSidebar();
            });

            const suratToggle = document.getElementById('surat-toggle');
            const suratSubmenu = document.getElementById('surat-submenu');
            const suratChevron = document.getElementById('surat-chevron');
            if (suratToggle) {
                suratToggle.addEventListener('click', () => {
                    suratSubmenu.classList.toggle('hidden');
                    suratChevron.classList.toggle('rotate-180');
                });
            }
        </script>
    </body>
</html>
