<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Semester') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Detail Semester</h3>

                    <div class="mb-4">
                        <x-input-label for="nama_semester" :value="__('Nama Semester')" />
                        <p class="mt-1 text-sm text-gray-900">{{ $semester->nama_semester }}</p>
                    </div>

                    <div class="mb-4">
                        <x-input-label for="tahun_akademik" :value="__('Tahun Akademik')" />
                        <p class="mt-1 text-sm text-gray-900">{{ $semester->tahun_akademik }}</p>
                    </div>

                    <div class="mb-4">
                        <x-input-label for="jenis_semester" :value="__('Jenis Semester')" />
                        <p class="mt-1 text-sm text-gray-900">{{ $semester->jenis_semester }}</p>
                    </div>

                    <div class="mb-4">
                        <x-input-label for="status" :value="__('Status')" />
                        <p class="mt-1 text-sm text-gray-900">
                            @if($semester->is_active)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Tidak Aktif</span>
                            @endif
                        </p>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <x-secondary-button>
                            <a href="{{ route('admin.semesters.index') }}">
                                {{ __('Kembali ke Daftar Semester') }}
                            </a>
                        </x-secondary-button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
