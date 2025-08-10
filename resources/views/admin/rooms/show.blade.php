<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Ruangan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                        <h2 class="text-2xl font-bold mb-6">Detail Ruangan</h2>

                        <div class="bg-white shadow-md rounded-lg p-6">
                            <div class="mb-4">
                                <p class="text-gray-700 text-sm font-bold">Nama Ruangan:</p>
                                <p class="text-gray-900 text-lg">{{ $room->name }}</p>
                            </div>

                            <div class="mb-4">
                                <p class="text-gray-700 text-sm font-bold">Kode Ruangan:</p>
                                <p class="text-gray-900 text-lg">{{ $room->code }}</p>
                            </div>

                            <div class="mb-4">
                                <p class="text-gray-700 text-sm font-bold">Kapasitas:</p>
                                <p class="text-gray-900 text-lg">{{ $room->capacity ?? 'Tidak ditentukan' }}</p>
                            </div>

                            <div class="flex items-center justify-between mt-6">
                                @if(Auth::user()->hasPermissionTo('edit rooms'))
                                    <a href="{{ route('admin.rooms.edit', $room->id) }}" class="bg-gray-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                        Edit Ruangan
                                    </a>
                                @endif
                                <a href="{{ route('admin.rooms.index') }}" class="inline-block align-baseline font-bold text-sm text-gray-500 hover:text-blue-800">
                                    Kembali ke Daftar Ruangan
                                </a>
                            </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

