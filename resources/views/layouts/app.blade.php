<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIK Desa')</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        /* Perbaikan tampilan Select2 agar cocok dengan Tailwind */
        .select2-container .select2-selection--single {
            height: 42px !important;
            border: 1px solid #d1d5db !important;
            border-radius: 0.375rem !important;
            padding: 5px 0;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px !important;
        }

        /* Highlight menu aktif */
        .nav-active {
            background-color: #374151;
            /* gray-700 */
            color: white !important;
        }

        /* Scrollbar Sidebar yang lebih tipis */
        nav::-webkit-scrollbar {
            width: 4px;
        }

        nav::-webkit-scrollbar-thumb {
            background-color: #4b5563;
            border-radius: 4px;
        }
    </style>
</head>

<body class="bg-gray-100 font-sans antialiased" x-data="{ sidebarOpen: false }">

    <div class="flex h-screen overflow-hidden">

        <aside
            class="w-64 bg-gray-900 text-white flex-col fixed md:relative z-30 h-full transition-transform transform md:translate-x-0"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'">

            @php
                $profilDesa = \App\Models\ProfilDesa::first();
            @endphp

            <div
                class="p-4 flex items-center justify-center h-20 bg-gray-800 shadow-md border-b border-gray-700 flex-shrink-0">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                    @if ($profilDesa && $profilDesa->logo)
                        <img src="{{ asset('storage/' . $profilDesa->logo) }}" alt="Logo"
                            class="h-10 w-10 object-contain rounded-full bg-white p-1">
                    @else
                        <i class="fas fa-landmark text-3xl text-blue-400"></i>
                    @endif

                    <h1 class="text-base font-bold tracking-wider text-white uppercase leading-tight">
                        {{ $profilDesa->nama_desa ?? 'SIK DESA' }}
                    </h1>
                </a>
            </div>

            <nav class="mt-4 px-2 space-y-1 flex-1 overflow-y-auto">

                <a href="{{ route('dashboard') }}"
                    class="group flex items-center px-4 py-3 text-sm font-medium rounded-md hover:bg-gray-700 hover:text-white transition {{ request()->routeIs('dashboard') ? 'nav-active' : 'text-gray-300' }}">
                    <i class="fas fa-tachometer-alt mr-3 text-lg w-6 text-center"></i>
                    Dashboard
                </a>

                <p class="px-4 pt-4 pb-2 text-xs font-bold text-gray-500 uppercase tracking-wider">Kependudukan</p>

                <div x-data="{ open: {{ request()->routeIs('penduduk.pendatang') || request()->routeIs('penduduk.pindah') || request()->routeIs('penduduk.meninggal') ? 'true' : 'false' }} }" class="mb-1">

                    <div
                        class="flex items-center justify-between w-full rounded-md transition-colors duration-200 
                        {{ request()->routeIs('penduduk.index') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">

                        <a href="{{ route('penduduk.index') }}"
                            class="flex-1 flex items-center px-4 py-3 text-sm font-medium">
                            <i class="fas fa-users mr-3 text-lg w-6 text-center"></i>
                            <span>Data Penduduk</span>
                        </a>

                        <button @click="open = !open" type="button"
                            class="px-4 py-3 border-l border-gray-700 text-gray-400 hover:text-white focus:outline-none hover:bg-gray-600 rounded-r-md">
                            <i class="fas fa-chevron-down w-3 h-3 transition-transform duration-200"
                                :class="open ? 'transform rotate-180' : ''"></i>
                        </button>
                    </div>

                    <div x-show="open" x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        class="space-y-1 mt-1 bg-gray-800 rounded-md overflow-hidden pb-1 ml-2 shadow-inner">

                        <a href="{{ route('penduduk.pendatang') }}"
                            class="block pl-10 pr-4 py-2 text-sm transition-colors duration-200 
                           {{ request()->routeIs('penduduk.pendatang') ? 'text-white font-bold bg-gray-700 border-l-4 border-blue-500' : 'text-gray-400 hover:text-white hover:bg-gray-700' }}">
                            <i class="fas fa-user-plus mr-2 text-blue-400"></i> Pendatang
                        </a>

                        <a href="{{ route('penduduk.pindah') }}"
                            class="block pl-10 pr-4 py-2 text-sm transition-colors duration-200 
                           {{ request()->routeIs('penduduk.pindah') ? 'text-white font-bold bg-gray-700 border-l-4 border-yellow-500' : 'text-gray-400 hover:text-white hover:bg-gray-700' }}">
                            <i class="fas fa-walking mr-2 text-yellow-400"></i> Pindah Keluar
                        </a>

                        <a href="{{ route('penduduk.meninggal') }}"
                            class="block pl-10 pr-4 py-2 text-sm transition-colors duration-200 
                           {{ request()->routeIs('penduduk.meninggal') ? 'text-white font-bold bg-gray-700 border-l-4 border-gray-500' : 'text-gray-400 hover:text-white hover:bg-gray-700' }}">
                            <i class="fas fa-tombstone mr-2 text-gray-400"></i> Data Kematian
                        </a>

                    </div>
                </div>
                <a href="{{ route('kk.index') }}"
                    class="group flex items-center px-4 py-3 text-sm font-medium rounded-md hover:bg-gray-700 hover:text-white transition {{ request()->routeIs('kk.*') ? 'nav-active' : 'text-gray-300' }}">
                    <i class="fas fa-file-alt mr-3 text-lg w-6 text-center"></i>
                    Kartu Keluarga
                </a>

                <p class="px-4 pt-4 pb-2 text-xs font-bold text-gray-500 uppercase tracking-wider">Master Data</p>

                <a href="{{ route('dusun.index') }}"
                    class="group flex items-center px-4 py-3 text-sm font-medium rounded-md hover:bg-gray-700 hover:text-white transition {{ request()->routeIs('dusun.*') ? 'nav-active' : 'text-gray-300' }}">
                    <i class="fas fa-map-signs mr-3 text-lg w-6 text-center"></i>
                    Dusun
                </a>

                <a href="{{ route('rw.index') }}"
                    class="group flex items-center px-4 py-3 text-sm font-medium rounded-md hover:bg-gray-700 hover:text-white transition {{ request()->routeIs('rw.*') ? 'nav-active' : 'text-gray-300' }}">
                    <i class="fas fa-project-diagram mr-3 text-lg w-6 text-center"></i>
                    RW
                </a>

                <a href="{{ route('rt.index') }}"
                    class="group flex items-center px-4 py-3 text-sm font-medium rounded-md hover:bg-gray-700 hover:text-white transition {{ request()->routeIs('rt.*') ? 'nav-active' : 'text-gray-300' }}">
                    <i class="fas fa-sitemap mr-3 text-lg w-6 text-center"></i>
                    RT
                </a>

                @if (auth()->user()->role == 'admin')
                    <div class="mt-8 mb-2 px-4 text-xs font-bold text-gray-500 uppercase tracking-wider">
                        Pengaturan
                    </div>

                    <a href="{{ route('users.index') }}"
                        class="group flex items-center px-4 py-3 text-sm font-medium rounded-md hover:bg-gray-700 hover:text-white transition {{ request()->routeIs('users.*') ? 'nav-active' : 'text-gray-300' }}">
                        <i class="fas fa-users-cog mr-3 text-lg w-6 text-center"></i>
                        Manajemen User
                    </a>

                    <a href="{{ route('profil.index') }}"
                        class="group flex items-center px-4 py-3 text-sm font-medium rounded-md hover:bg-gray-700 hover:text-white transition {{ request()->routeIs('profil.*') ? 'nav-active' : 'text-gray-300' }}">
                        <i class="fas fa-building mr-3 text-lg w-6 text-center"></i>
                        Profil Desa
                    </a>
                @endif

                <div class="pb-20"></div>
            </nav>
        </aside>

        <div x-show="sidebarOpen" @click="sidebarOpen = false"
            class="fixed inset-0 z-20 bg-black opacity-50 transition-opacity md:hidden"></div>

        <div class="flex-1 flex flex-col overflow-hidden">

            <header class="h-16 bg-white shadow flex items-center justify-between px-6 z-10 flex-shrink-0">
                <div class="flex items-center">
                    <button @click="sidebarOpen = !sidebarOpen" class="md:hidden text-gray-500 focus:outline-none">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>

                    <h2 class="text-xl font-semibold text-gray-800 ml-4">
                        @yield('header', 'Admin Dashboard')
                    </h2>
                </div>

                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-600 font-bold hidden md:inline">
                        Halo, {{ Auth::user()->name ?? 'Pengguna' }}
                        <span class="text-xs font-normal text-gray-400">({{ ucfirst(Auth::user()->role) }})</span>
                    </span>

                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                            class="text-red-500 hover:text-red-700 text-sm font-bold border border-red-200 px-3 py-1 rounded hover:bg-red-50 transition">
                            <i class="fas fa-sign-out-alt mr-1"></i> Logout
                        </button>
                    </form>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                @yield('content')
            </main>
        </div>
    </div>

</body>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>

</html>
