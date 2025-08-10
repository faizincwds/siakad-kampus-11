<header class="sticky top-0 z-40 flex w-full bg-white drop-shadow-sm">
    <div class="flex flex-grow items-center justify-between px-4 py-2 shadow-sm lg:px-6 2xl:px-11">

        <!-- Left: Logo or Sidebar Toggle -->
        <div class="flex items-center gap-2">
            <!-- Sidebar toggle button (mobile only) -->
            <button
                class="text-gray-600 hover:text-blue-500 focus:outline-none lg:hidden"
                x-on:click="$dispatch('toggle-sidebar')"
            >
                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>

            <!-- Logo -->
            <a href="{{ url('/') }}" class="text-xl font-bold text-blue-600">
                TailAdmin
            </a>
        </div>

        <!-- Right: User Profile Dropdown -->
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" class="flex items-center gap-2 text-gray-700 hover:text-blue-600 focus:outline-none">
                <img src="{{ asset('images/avatar.png') }}" alt="User Avatar"
                     class="h-8 w-8 rounded-full border border-gray-300">
                <span class="hidden text-sm font-medium lg:block">Admin</span>
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <!-- Dropdown -->
            <div x-show="open" @click.away="open = false"
                 class="absolute right-0 mt-2 w-48 rounded-lg bg-white py-2 shadow-md z-50">
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    Profil
                </a>
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    Pengaturan
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        Keluar
                    </button>
                </form>
            </div>
        </div>

    </div>
</header>
