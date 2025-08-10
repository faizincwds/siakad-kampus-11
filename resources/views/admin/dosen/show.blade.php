<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Dosen') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">Detail Dosen: {{ $dosen->nama_lengkap_gelar }}</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <p class="text-sm font-medium text-gray-700">NIDN:</p>
                            <p class="mt-1 text-gray-900">{{ $dosen->nidn }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700">Nama Lengkap:</p>
                            <p class="mt-1 text-gray-900">{{ $dosen->nama_lengkap }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700">Gelar Depan:</p>
                            <p class="mt-1 text-gray-900">{{ $dosen->gelar_depan ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700">Gelar Belakang:</p>
                            <p class="mt-1 text-gray-900">{{ $dosen->gelar_belakang ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700">Tempat Lahir:</p>
                            <p class="mt-1 text-gray-900">{{ $dosen->tempat_lahir ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700">Tanggal Lahir:</p>
                            <p class="mt-1 text-gray-900">{{ $dosen->tanggal_lahir ? \Carbon\Carbon::parse($dosen->tanggal_lahir)->format('d M Y') : '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700">Jenis Kelamin:</p>
                            <p class="mt-1 text-gray-900">{{ $dosen->jenis_kelamin == 'L' ? 'Laki-laki' : ($dosen->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700">Alamat:</p>
                            <p class="mt-1 text-gray-900">{{ $dosen->alamat ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700">Nomor Telepon:</p>
                            <p class="mt-1 text-gray-900">{{ $dosen->nomor_telepon ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700">Email:</p>
                            <p class="mt-1 text-gray-900">{{ $dosen->email ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700">Program Studi Utama:</p>
                            <p class="mt-1 text-gray-900">{{ $dosen->programStudi->nama ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700">Dibuat Pada:</p>
                            <p class="mt-1 text-gray-900">{{ $dosen->created_at ? $dosen->created_at->format('d M Y H:i') : '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700">Diperbarui Pada:</p>
                            <p class="mt-1 text-gray-900">{{ $dosen->updated_at ? $dosen->updated_at->format('d M Y H:i') : '-' }}</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a href="{{ route('admin.dosen.edit', $dosen->id) }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600 active:bg-yellow-700 focus:outline-none focus:border-yellow-900 focus:ring ring-yellow-300 disabled:opacity-25 transition ease-in-out duration-150 mr-2">Edit</a>
                        <a href="{{ route('admin.dosen.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 active:bg-gray-400 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
