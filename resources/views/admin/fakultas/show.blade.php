<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Fakultas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">Detail Fakultas: {{ $fakultas->nama }}</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <p class="text-sm font-medium text-gray-700">Nama Fakultas:</p>
                            <p class="mt-1 text-gray-900">{{ $fakultas->nama }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700">Kode Fakultas:</p>
                            <p class="mt-1 text-gray-900">{{ $fakultas->kode ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700">Dibuat Pada:</p>
                            <p class="mt-1 text-gray-900">{{$fakultas->created_at ? $fakultas->created_at->format('d M Y H:i') : 'Belum tersedia'}}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700">Diperbarui Pada:</p>
                            <p class="mt-1 text-gray-900">{{ $fakultas->updated_at ? $fakultas->updated_at->format('d M Y H:i') : 'Belum tersedia'}}</p>
                        </div>
                    </div>

                    <h4 class="text-md font-medium mt-6 mb-3">Program Studi di bawah Fakultas Ini:</h4>
                    @if ($fakultas->programStudis->isEmpty())
                        <p class="text-sm text-gray-500">Belum ada Program Studi yang terdaftar di bawah fakultas ini.</p>
                    @else
                        <ul class="list-disc list-inside space-y-1 text-gray-900">
                            @foreach ($fakultas->programStudis as $prodi)
                                <li>{{ $prodi->nama }} ({{ $prodi->jenjang }}, Kode: {{ $prodi->kode ?? '-' }})</li>
                            @endforeach
                        </ul>
                    @endif

                    <div class="flex items-center justify-end mt-4">
                        <a href="{{ route('admin.fakultas.edit', $fakultas->id) }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600 active:bg-yellow-700 focus:outline-none focus:border-yellow-900 focus:ring ring-yellow-300 disabled:opacity-25 transition ease-in-out duration-150 mr-2">Edit</a>
                        <a href="{{ route('admin.fakultas.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 active:bg-gray-400 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
