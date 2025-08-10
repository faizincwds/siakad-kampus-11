<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manajemen Permission') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-12">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="max-w-lg mx-auto p-6 bg-white rounded shadow">
                    <h2 class="text-lg font-bold mb-4">{{ isset($permission) ? 'Edit' : 'Tambah' }} Permission</h2>
                    <form action="{{ route('admin.permissions.store') }}" method="POST">
                        @csrf
                        @if(isset($permission)) @method('PUT') @endif

                        <div class="mb-4">
                            <label class="block text-sm font-medium">Nama Permission</label>
                            <input type="text" name="name" value="{{ old('name', $permission->name ?? '') }}" class="mt-1 block w-full rounded border-gray-300">
                            @error('name')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium">Deskripsi</label>
                            <textarea name="description" class="mt-1 block w-full rounded border-gray-300">{{ old('description', $permission->description ?? '') }}</textarea>
                            @error('description')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
