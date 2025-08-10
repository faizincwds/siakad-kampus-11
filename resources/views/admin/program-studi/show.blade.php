<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Program Studi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">Detail Program Studi: {{ $programStudi->nama }}</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <p class="text-sm font-medium text-gray-700">Nama Program Studi:</p>
                            <p class="mt-1 text-gray-900">{{ $programStudi->nama }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700">Jenjang:</p>
                            <p class="mt-1 text-gray-900">{{ $programStudi->jenjang }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700">Kode Program Studi:</p>
                            <p class="mt-1 text-gray-900">{{ $programStudi->kode ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700">Fakultas:</p>
                            <p class="mt-1 text-gray-900">{{ $programStudi->fakultas->nama ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700">Dibuat Pada:</p>
                            <p class="mt-1 text-gray-900">{{ $programStudi->created_at->format('d M Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700">Diperbarui Pada:</p>
                            <p class="mt-1 text-gray-900">{{ $programStudi->updated_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a href="{{ route('admin.program-studi.edit', $programStudi->id) }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600 active:bg-yellow-700 focus:outline-none focus:border-yellow-900 focus:ring ring-yellow-300 disabled:opacity-25 transition ease-in-out duration-150 mr-2">Edit</a>
                        <a href="{{ route('admin.program-studi.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 active:bg-gray-400 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
