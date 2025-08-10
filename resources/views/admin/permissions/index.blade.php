<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manajemen Permission') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-12">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif
                <!-- Konten utama -->
                <div class="mb-4">
                    <a href="{{ route('admin.permissions.create') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Tambah Permission</a>
                    <a href="{{ route('admin.permissions.manage') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Manager Permission</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="mxn-w-full table-auto border">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="px-6 py-4 whitespace-nowrap">Nama</th>
                                <th class="px-6 py-4 whitespace-nowrap">Deskripsi</th>
                                <th class="px-6 py-4 whitespace-nowrap">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permissions as $permission)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $permission->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $permission->description }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('admin.permissions.edit', $permission->id) }}" class="text-gray-600 hover:text-indigo-900 mr-2">Edit</a>
                                        <form action="{{ route('admin.permissions.destroy', $permission->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Yakin hapus?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $permissions->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
