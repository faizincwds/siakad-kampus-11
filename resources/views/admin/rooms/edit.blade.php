<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Ruangan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                        <h2 class="text-2xl font-bold mb-6">Edit Ruangan: {{ $room->name }}</h2>

                        <div class="bg-white shadow-md rounded-lg p-6">
                            <form action="{{ route('admin.rooms.update', $room->id) }}" method="POST">
                                @csrf
                                @method('PUT') {{-- Gunakan method PUT untuk update --}}

                                <div class="mb-4">
                                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nama Ruangan:</label>
                                    <input type="text" name="name" id="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror" value="{{ old('name', $room->name) }}" required>
                                    @error('name')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="code" class="block text-gray-700 text-sm font-bold mb-2">Kode Ruangan:</label>
                                    <input type="text" name="code" id="code" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('code') border-red-500 @enderror" value="{{ old('code', $room->code) }}" required>
                                    @error('code')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-6">
                                    <label for="capacity" class="block text-gray-700 text-sm font-bold mb-2">Kapasitas (opsional):</label>
                                    <input type="number" name="capacity" id="capacity" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('capacity') border-red-500 @enderror" value="{{ old('capacity', $room->capacity) }}">
                                    @error('capacity')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex items-center justify-between">
                                    <button type="submit" class="bg-gray-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                        Perbarui Ruangan
                                    </button>
                                    <a href="{{ route('admin.rooms.index') }}" class="inline-block align-baseline font-bold text-sm text-gray-500 hover:text-blue-800">
                                        Batal
                                    </a>
                                </div>
                            </form>
                        </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
