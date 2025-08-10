<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SIAKAD | @yield('title')</title>

    {{-- Memuat aset CSS dan JS melalui Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    x-data="{ page: '@yield('x-data')', 'loaded': true, 'darkMode': false, 'stickyMenu': false, 'sidebarToggle': false, 'scrollTop': false }"
    x-init="darkMode = JSON.parse(localStorage.getItem('darkMode')); $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)));
    " :class="{'dark bg-gray-900': darkMode === true}"
>
    <!-- ===== Preloader Start ===== -->
    <!-- Logika preloader disederhanakan: Hapus event listener DOMContentLoaded dan langsung gunakan setTimeout. -->
    <div x-show="loaded" x-init="setTimeout(() => loaded = false, 500)" class="fixed left-0 top-0 z-999999 flex h-screen w-screen items-center justify-center bg-white dark:bg-black">
      <div class="h-16 w-16 animate-spin rounded-full border-4 border-solid border-brand-500 border-t-transparent"></div>
    </div>
    <!-- ===== Preloader End ===== -->


    <!-- ===== Page Wrapper Start ===== -->
    <div class="flex h-screen overflow-hidden">

        @include('partials.sidebar')

        <div class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto">

            @include('partials.header')

            <main>
                <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
                    <!-- Breadcrumb Start -->
                    <div>
                        <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
                            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90" >@yield('title')</h2>
                            @if ( View::hasSection('title') && trim(View::yieldContent('title')) !== 'Dashboard')
                                <nav>
                                    <ol class="flex items-center gap-1.5">
                                        <li>
                                            <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400" href="{{ route('dashboard') }}">
                                            Dashboard
                                                <svg class="stroke-current" width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M6.0765 12.667L10.2432 8.50033L6.0765 4.33366" stroke="" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                            </a>
                                        </li>
                                        <li class="text-sm text-gray-800 dark:text-white/90" >@yield('title')</li>
                                    </ol>
                                </nav>
                            @endif
                        </div>
                    </div>
                    <!-- Breadcrumb End -->

                        @yield('content')

                </div>
            </main>

        </div>

    </div>
    <!-- ===== Page Wrapper End ===== -->
</body>

</html>
