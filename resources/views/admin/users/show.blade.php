<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Pengguna') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">Informasi Pengguna</h3>

                    <div class="mb-4">
                        <p class="text-sm text-gray-600">Nama:</p>
                        <p class="text-lg font-semibold">{{ $user->name }}</p>
                    </div>

                    <div class="mb-4">
                        <p class="text-sm text-gray-600">Email:</p>
                        <p class="text-lg font-semibold">{{ $user->email }}</p>
                    </div>

                    <div class="mb-4">
                        <p class="text-sm text-gray-600">Peran:</p>
                        <p class="text-lg font-semibold">{{ $user->role->name ?? 'N/A' }}</p>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
