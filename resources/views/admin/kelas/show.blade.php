<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Kelas/Jadwal') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Kelas: {{ $kelas->nama_kelas }}</h3>

                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <p class="text-sm font-bold text-gray-700">Nama Kelas:</p>
                            <p class="text-gray-900 text-lg">{{ $kelas->nama_kelas }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-700">Mata Kuliah:</p>
                            <p class="text-gray-900 text-lg">{{ $kelas->mataKuliah->nama_mk ?? 'N/A' }} ({{ $kelas->mataKuliah->kode_mk ?? 'N/A' }})</p>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-700">Dosen Pengampu:</p>
                            <p class="text-gray-900 text-lg">{{ $kelas->dosen->nama_lengkap ?? 'N/A' }}</p>
                        </div>
                        <div class="mb-4">
                            <x-input-label for="semester" :value="__('Semester Akademik')" />
                            <p class="mt-1 text-sm text-gray-900">{{ $kelas->semester->nama_semester }}</p> {{-- <-- Tampilkan nama semester --}}
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-700">Ruangan:</p>
                            <p class="text-gray-900 text-lg">{{ $kelas->room->name ?? 'N/A' }} ({{ $kelas->room->code ?? 'N/A' }})</p>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-700">Jadwal:</p>
                            <p class="text-gray-900 text-lg">{{ ucfirst($kelas->day_of_week) }}, {{ \Carbon\Carbon::parse($kelas->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($kelas->end_time)->format('H:i') }}</p>
                        </div>
                    </div>

                    <h4 class="text-md font-medium text-gray-900 mb-3">Daftar Mahasiswa Terdaftar:</h4>
                        <x-secondary-button>
                            <a href="{{ route('admin.kelas.mahasiswa.index', ['kela' => $kelas->id]) }}">
                                {{ __('Tambah Mahasiswa' ) }}
                            </a>
                        </x-secondary-button>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Mahasiswa</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIM</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai Akhir</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($kelas->mahasiswas as $mahasiswa)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $mahasiswa->nama_lengkap }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $mahasiswa->nim }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $mahasiswa->pivot->nilai_akhir ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $mahasiswa->pivot->status_kelas }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                        Belum ada mahasiswa terdaftar di kelas ini.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        @if(Auth::user()->hasPermissionTo('edit kelas'))
                            <x-primary-button class="ms-4">
                                <a href="{{ route('admin.kelas.edit', $kelas->id) }}">
                                    {{ __('Edit Kelas') }}
                                </a>
                            </x-primary-button>
                        @endif
                        <x-secondary-button class="ms-4">
                            <a href="{{ route('admin.kelas.index') }}">
                                {{ __('Kembali ke Daftar Kelas') }}
                            </a>
                        </x-secondary-button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
