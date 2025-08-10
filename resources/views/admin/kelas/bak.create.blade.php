<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Kelas/Jadwal Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <x-secondary-button>
                            <a href="{{ route('admin.kelas.index') }}">
                                {{ __('Kembali ke Daftar Kelas') }}
                            </a>
                        </x-secondary-button>
                    </div>

                    @if($errors->has('schedule_conflict'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <strong class="font-bold">Terjadi Kesalahan!</strong>
                            <span class="block sm:inline">Periksa kembali input Anda.</span>
                            <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                                {{ $errors->first('schedule_conflict') }}
                            </ul>
                        </div>
                    @endif
                        {{-- @if($errors->has('schedule_conflict'))
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-4" role="alert">
                                <span class="block sm:inline">{{ $errors->first('schedule_conflict') }}</span>
                            </div>
                        @endif --}}
                    <form action="{{ route('admin.kelas.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="nama_kelas" :value="__('Nama Kelas')" />
                                <x-text-input id="nama_kelas" class="block mt-1 w-full" type="text" name="nama_kelas" :value="old('nama_kelas')" required autofocus />
                                <x-input-error :messages="$errors->get('nama_kelas')" class="mt-2" />
                            </div>
                            <div>
                                <x-forms.select-input id="semester_id" name="semester_id" class="block mt-1 w-full" required
                                    :options="$semesters->mapWithKeys(function ($semester) {
                                        $label = $semester->nama_semester;
                                        if ($semester->is_active) {
                                            $label .= ' (Aktif)';
                                        }
                                        return [$semester->id => $label];
                                    })->prepend('Pilih Semester', '')->toArray()"
                                    :value="old('semester_id')"
                                />
                            </div>
                            <div>
                                <x-input-label for="mata_kuliah_id" :value="__('Mata Kuliah')" />
                                {{-- Menggunakan komponen x-select-input --}}
                                <x-forms.select-input id="mata_kuliah_id" name="mata_kuliah_id" class="block mt-1 w-full" required
                                    :options="$mataKuliah->pluck('nama_mk', 'id')->prepend('Pilih Mata Kuliah', '')->toArray()"
                                    :value="old('mata_kuliah_id')"
                                />
                                <x-input-error :messages="$errors->get('mata_kuliah_id')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="dosen_id" :value="__('Dosen Pengampu')" />
                                {{-- Menggunakan komponen x-select-input --}}
                                <x-forms.select-input id="dosen_id" name="dosen_id" class="block mt-1 w-full" required
                                    :options="$dosen->mapWithKeys(fn($d) => [$d->id => $d->nama_lengkap . ' (' . $d->nidn . ')'])->prepend('Pilih Dosen', '')->toArray()"
                                    :value="old('dosen_id')"
                                />
                                <x-input-error :messages="$errors->get('dosen_id')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="room_id" :value="__('Ruangan')" />
                                {{-- Menggunakan komponen x-select-input --}}
                                <x-forms.select-input id="room_id" name="room_id" class="block mt-1 w-full" required
                                    :options="$rooms->pluck('name', 'id')->prepend('Pilih Ruangan', '')->toArray()"
                                    :value="old('room_id')"
                                />
                                <x-input-error :messages="$errors->get('room_id')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="day_of_week" :value="__('Hari Kuliah')" />
                                {{-- Menggunakan komponen x-select-input --}}
                                <x-forms.select-input id="day_of_week" name="day_of_week" class="block mt-1 w-full" required
                                    :options="collect($daysOfWeek)->prepend('Pilih Hari', '')->toArray()"
                                    :value="old('day_of_week')"
                                />
                                <x-input-error :messages="$errors->get('day_of_week')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="start_time" :value="__('Jam Mulai')" />
                                <x-text-input id="start_time" class="block mt-1 w-full" type="time" name="start_time" :value="old('start_time')" required />
                                <x-input-error :messages="$errors->get('start_time')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="end_time" :value="__('Jam Selesai')" />
                                <x-text-input id="end_time" class="block mt-1 w-full" type="time" name="end_time" :value="old('end_time')" required />
                                <x-input-error :messages="$errors->get('end_time')" class="mt-2" />
                            </div>
                        </div>



                        <div class="flex items-center justify-end mt-4">
                            <x-secondary-button class="ms-4">
                                <a href="{{ route('admin.kelas.index') }}">
                                    {{ __('Batal') }}
                                </a>
                            </x-secondary-button>
                            <x-primary-button class="ms-4">
                                {{ __('Simpan Kelas') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
