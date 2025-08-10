<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat/Edit KRS untuk Mahasiswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('admin.krs.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <x-input-label for="mahasiswa_id" :value="__('Pilih Mahasiswa')" />
                            <select name="mahasiswa_id" id="mahasiswa_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required onchange="this.form.submit()">
                                <option value="">{{ __('Pilih Mahasiswa') }}</option>
                                @foreach($mahasiswas as $mahasiswa)
                                    <option value="{{ $mahasiswa->id }}" {{ $selectedMahasiswaId == $mahasiswa->id ? 'selected' : '' }}>
                                        {{ $mahasiswa->nama_lengkap }} ({{ $mahasiswa->nim }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('mahasiswa_id')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="semester_id" :value="__('Pilih Semester')" />
                            <select name="semester_id" id="semester_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required onchange="this.form.submit()">
                                <option value="">{{ __('Pilih Semester') }}</option>
                                @foreach($semesters as $semester)
                                    <option value="{{ $semester->id }}" {{ $selectedSemesterId == $semester->id ? 'selected' : '' }}>
                                        {{ $semester->tahun_ajaran }} {{ $semester->nama_semester }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('semester_id')" class="mt-2" />
                        </div>
                    </div>

                    @if ($selectedMahasiswaId && $selectedSemesterId)
                        <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Pilih Kelas yang Tersedia') }}</h3>

                        @if($kelasAvailable->isEmpty())
                            <p class="text-gray-600 mb-4">{{ __('Tidak ada kelas yang tersedia untuk dipilih di semester ini atau semua sudah dipilih.') }}</p>
                        @else
                            <div class="overflow-x-auto mb-6 max-h-96">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="p-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                {{ __('Pilih') }}
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                {{ __('Mata Kuliah') }}
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                {{ __('Kelas') }}
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                {{ __('SKS') }}
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                {{ __('Dosen') }}
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                {{ __('Jadwal') }}
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                {{ __('Ruangan') }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($kelasAvailable as $kelas)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    <input type="checkbox" name="kelas_ids[]" value="{{ $kelas->id }}" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $kelas->mataKuliah->nama_mk }} ({{ $kelas->mataKuliah->kode_mk }})
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $kelas->nama_kelas }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $kelas->mataKuliah->sks }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $kelas->dosen->nama_lengkap }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $kelas->day_name }}, {{ $kelas->start_time->format('H:i') }} - {{ $kelas->end_time->format('H:i') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $kelas->room->nama_room }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>
                                {{ __('Simpan KRS') }}
                            </x-primary-button>
                        </div>
                    @else
                        <p class="text-gray-600">{{ __('Silakan pilih mahasiswa dan semester untuk melihat kelas yang tersedia.') }}</p>
                    @endif
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
