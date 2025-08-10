<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Mata Kuliah') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">Detail Mata Kuliah: {{ $mataKuliah->nama_mk }}</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <p class="text-sm font-medium text-gray-700">Kode MK:</p>
                            <p class="mt-1 text-gray-900">{{ $mataKuliah->kode_mk }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700">Nama MK:</p>
                            <p class="mt-1 text-gray-900">{{ $mataKuliah->nama_mk }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700">SKS:</p>
                            <p class="mt-1 text-gray-900">{{ $mataKuliah->sks }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700">Semester Ditawarkan:</p>
                            <p class="mt-1 text-gray-900">{{ $mataKuliah->semester }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700">Jenis:</p>
                            <p class="mt-1 text-gray-900">{{ $mataKuliah->jenis_mata_kuliah }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700">Program Studi:</p>
                            <p class="mt-1 text-gray-900">{{ $mataKuliah->programStudi->nama ?? 'N/A' }}</p> {{-- Menggunakan kolom 'nama' --}}
                        </div>
                        <div class="col-span-full">
                            <p class="text-sm font-medium text-gray-700">Deskripsi:</p>
                            <p class="mt-1 text-gray-900">{{ $mataKuliah->deskripsi ?? '-' }}</p>
                        </div>
                        <div class="col-span-full">
                            <p class="text-sm font-medium text-gray-700">Kurikulum Terkait:</p>
                            <ul class="list-disc list-inside mt-1 text-gray-900">
                                @forelse ($mataKuliah->kurikulum as $kurikulum)
                                    <li>{{ $kurikulum->nama_kurikulum }} ({{ $kurikulum->tahun_mulai }} - {{ $kurikulum->programStudi->nama ?? 'N/A' }})</li> {{-- Menggunakan kolom 'nama' --}}
                                @empty
                                    <li>Tidak ada kurikulum terkait.</li>
                                @endforelse
                            </ul>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700">Dibuat Pada:</p>
                            <p class="mt-1 text-gray-900">{{ $mataKuliah->created_at->format('d M Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700">Diperbarui Pada:</p>
                            <p class="mt-1 text-gray-900">{{ $mataKuliah->updated_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a href="{{ route('admin.mata-kuliah.edit', $mataKuliah->id) }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600 active:bg-yellow-700 focus:outline-none focus:border-yellow-900 focus:ring ring-yellow-300 disabled:opacity-25 transition ease-in-out duration-150 mr-2">Edit</a>
                        <a href="{{ route('admin.mata-kuliah.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 active:bg-gray-400 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
