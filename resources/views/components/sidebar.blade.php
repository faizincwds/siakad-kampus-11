<aside
    x-data="{ open: true }"
    x-show="open"
    @toggle-sidebar.window="open = !open"
    class="fixed inset-y-0 left-0 z-30 w-64 bg-white border-r shadow-md overflow-y-auto transition-transform transform lg:translate-x-0 lg:static lg:inset-0"
>
    <div class="p-4 flex items-center justify-between lg:justify-center border-b">
        <a href="{{ url('/') }}" class="text-xl font-bold text-blue-600">TailAdmin</a>
        <!-- Close button (mobile) -->
        <button @click="open = false" class="text-gray-500 hover:text-red-500 lg:hidden">
            ✕
        </button>
    </div>

    <!-- Navigation -->
    <nav class="mt-4 space-y-2 px-4 text-sm">
        <a href="{{ route('dashboard') }}"
           class="flex items-center gap-3 rounded-md px-4 py-2 text-gray-700 hover:bg-blue-100 hover:text-blue-700 {{ request()->routeIs('dashboard') ? 'bg-blue-100 text-blue-700' : '' }}">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M3 12l2-2m0 0l7-7 7 7m-7-7v18"/>
            </svg>
            Dashboard
        </a>

        <a href="#"
           class="flex items-center gap-3 rounded-md px-4 py-2 text-gray-700 hover:bg-blue-100 hover:text-blue-700 {{ request()->routeIs('users.*') ? 'bg-blue-100 text-blue-700' : '' }}">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M17 20h5v-2a3 3 0 00-5.356-1.857M9 20H4v-2a3 3 0 015.356-1.857M15 11a4 4 0 10-8 0 4 4 0 008 0z"/>
            </svg>
            Manajemen User
        </a>

        <a href="#"
           class="flex items-center gap-3 rounded-md px-4 py-2 text-gray-700 hover:bg-blue-100 hover:text-blue-700 {{ request()->routeIs('settings') ? 'bg-blue-100 text-blue-700' : '' }}">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 4v1m0 14v1m8-8h1M4 12H3m15.364-6.364l.707.707M6.343 17.657l-.707.707m0-13.414l.707.707M17.657 17.657l-.707.707"/>
            </svg>
            Pengaturan
        </a>
    </nav>
</aside>
