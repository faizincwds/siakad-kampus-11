<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Kelas') }} - {{ $kelas->nama_kelas }}
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

                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <strong class="font-bold">Terjadi Kesalahan!</strong>
                            <span class="block sm:inline">Periksa kembali input Anda.</span>
                            <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                                @foreach ($errors->all() as $error)
                                    <li>{!! $error !!}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.kelas.update', $kelas->id) }}">
                        @csrf
                        @method('PUT') {{-- Penting: Gunakan PUT/PATCH untuk update --}}

                        <div>
                            <x-input-label for="nama_kelas" :value="__('Nama Kelas')" />
                            <x-text-input id="nama_kelas" class="block mt-1 w-full" type="text" name="nama_kelas" :value="old('nama_kelas', $kelas->nama_kelas)" required autofocus />
                            <x-input-error :messages="$errors->get('nama_kelas')" class="mt-2" />
                        </div>

                        <div class="mt-4">
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

                        <div class="mt-4">
                            <x-input-label for="mata_kuliah_id" :value="__('Mata Kuliah')" />
                            <x-forms.select-input id="mata_kuliah_id" name="mata_kuliah_id" class="block mt-1 w-full" required
                                :options="$mataKuliahs->pluck('nama_mk', 'id')->prepend('Pilih Mata Kuliah', '')->toArray()"
                                :value="old('mata_kuliah_id', $kelas->mata_kuliah_id)"
                            />
                            <x-input-error :messages="$errors->get('mata_kuliah_id')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="dosen_id" :value="__('Dosen Pengajar')" />
                            <x-forms.select-input id="dosen_id" name="dosen_id" class="block mt-1 w-full" required
                                :options="$dosens->pluck('nama_lengkap', 'id')->prepend('Pilih Dosen', '')->toArray()"
                                :value="old('dosen_id', $kelas->dosen_id)"
                            />
                            <x-input-error :messages="$errors->get('dosen_id')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="room_id" :value="__('Ruangan')" />
                            <x-forms.select-input id="room_id" name="room_id" class="block mt-1 w-full" required
                                :options="$rooms->pluck('name', 'id')->prepend('Pilih Ruangan', '')->toArray()"
                                :value="old('room_id', $kelas->room_id)"
                            />
                            <x-input-error :messages="$errors->get('room_id')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="day_of_week" :value="__('Hari')" />
                            <x-forms.select-input id="day_of_week" name="day_of_week" class="block mt-1 w-full" required
                                :options="[
                                    '' => 'Pilih Hari',
                                    'Monday' => 'Senin',
                                    'Tuesday' => 'Selasa',
                                    'Wednesday' => 'Rabu',
                                    'Thursday' => 'Kamis',
                                    'Friday' => 'Jumat',
                                    'Saturday' => 'Sabtu',
                                    'Sunday' => 'Minggu',
                                ]"
                                :value="old('day_of_week', $kelas->day_of_week)"
                            />
                            <x-input-error :messages="$errors->get('day_of_week')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="start_time" :value="__('Waktu Mulai')" />
                            <x-text-input id="start_time" name="start_time" type="time" class="block mt-1 w-full" required
                                value="{{ old('start_time', $kelas->start_time->format('H:i')) }}"
                            />
                            <x-input-error :messages="$errors->get('start_time')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="end_time" :value="__('Waktu Selesai')" />
                            <x-text-input id="end_time" name="end_time" type="time" class="block mt-1 w-full" required
                                value="{{ old('end_time', $kelas->end_time->format('H:i')) }}"
                            />
                            <x-input-error :messages="$errors->get('end_time')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ms-4">
                                {{ __('Perbarui Kelas') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
