<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Semester Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.semesters.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="tahun_akademik" :value="__('Tahun Akademik')" />
                                <x-text-input id="tahun_akademik" class="block mt-1 w-full" type="text" name="tahun_akademik" placeholder="Contoh: 2023/2024" :value="old('tahun_akademik')" required autofocus />
                                <x-input-error :messages="$errors->get('tahun_akademik')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="jenis_semester" :value="__('Jenis Semester')" />
                                <x-forms.select-input id="jenis_semester" name="jenis_semester" class="block mt-1 w-full" required
                                    :options="collect($jenisSemesters)->mapWithKeys(fn($js) => [$js => $js])->prepend('Pilih Jenis Semester', '')->toArray()"
                                    :value="old('jenis_semester')"
                                />
                                <x-input-error :messages="$errors->get('jenis_semester')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="nama_semester" :value="__('Nama Semester')" />
                                <x-text-input id="nama_semester" class="block mt-1 w-full" type="text" name="nama_semester" placeholder="Contoh: Ganjil 2023/2024" :value="old('nama_semester')" required />
                                <x-input-error :messages="$errors->get('nama_semester')" class="mt-2" />
                            </div>

                            <div class="md:col-span-2">
                                <label for="is_active" class="inline-flex items-center">
                                    <input id="is_active" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="is_active" value="1" {{ old('is_active') ? 'checked' : '' }}>
                                    <span class="ms-2 text-sm text-gray-600">{{ __('Atur sebagai Semester Aktif') }}</span>
                                </label>
                                <x-input-error :messages="$errors->get('is_active')" class="mt-2" />
                                <p class="text-sm text-gray-500 mt-1">Jika diaktifkan, semua semester lain akan otomatis dinonaktifkan.</p>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-secondary-button class="ms-4">
                                <a href="{{ route('admin.semesters.index') }}">
                                    {{ __('Batal') }}
                                </a>
                            </x-secondary-button>
                            <x-primary-button class="ms-4">
                                {{ __('Simpan Semester') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
