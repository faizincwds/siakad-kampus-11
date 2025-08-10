<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Mata Kuliah') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">Form Edit Mata Kuliah</h3>

                    <form action="{{ route('admin.mata-kuliah.update', $mataKuliah->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="kode_mk" class="block text-sm font-medium text-gray-700">Kode Mata Kuliah:</label>
                            <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('kode_mk') border-red-500 @enderror" id="kode_mk" name="kode_mk" value="{{ old('kode_mk', $mataKuliah->kode_mk) }}" required>
                            @error('kode_mk')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="nama_mk" class="block text-sm font-medium text-gray-700">Nama Mata Kuliah:</label>
                            <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('nama_mk') border-red-500 @enderror" id="nama_mk" name="nama_mk" value="{{ old('nama_mk', $mataKuliah->nama_mk) }}" required>
                            @error('nama_mk')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="sks" class="block text-sm font-medium text-gray-700">SKS:</label>
                            <input type="number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('sks') border-red-500 @enderror" id="sks" name="sks" value="{{ old('sks', $mataKuliah->sks) }}" min="1" max="9" required>
                            @error('sks')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="semester" class="block text-sm font-medium text-gray-700">Semester Ditawarkan:</label>
                            <input type="number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('semester') border-red-500 @enderror" id="semester" name="semester" value="{{ old('semester', $mataKuliah->semester) }}" min="1" max="14" required>
                            @error('semester')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="jenis_mata_kuliah" class="block text-sm font-medium text-gray-700">Jenis Mata Kuliah:</label>
                            <select class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('jenis_mata_kuliah') border-red-500 @enderror" id="jenis_mata_kuliah" name="jenis_mata_kuliah" required>
                                <option value="">Pilih Jenis Mata Kuliah</option>
                                <option value="Wajib">Wajib</option>
                                <option value="Pilihan">Pilihan</option>
                            </select>
                            @error('jenis_mata_kuliah')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="program_studi_id" class="block text-sm font-medium text-gray-700">Program Studi:</label>
                            <select class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('program_studi_id') border-red-500 @enderror" id="program_studi_id" name="program_studi_id" required>
                                <option value="">Pilih Program Studi</option>
                                @foreach ($programStudis as $prodi)
                                    <option value="{{ $prodi->id }}" {{ old('program_studi_id', $mataKuliah->program_studi_id) == $prodi->id ? 'selected' : '' }}>{{ $prodi->nama }}</option> {{-- Menggunakan kolom 'nama' --}}
                                @endforeach
                            </select>
                            @error('program_studi_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi (Opsional):</label>
                            <textarea class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('deskripsi') border-red-500 @enderror" id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $mataKuliah->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Section for associating with Kurikulum (Many-to-Many) --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Pilih Kurikulum Terkait:</label>
                            <div class="mt-2 space-y-2">
                                @forelse ($kurikulums as $kurikulum)
                                    <div class="flex items-center">
                                        <input type="checkbox" name="kurikulum_ids[]" id="kurikulum_{{ $kurikulum->id }}" value="{{ $kurikulum->id }}" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ (in_array($kurikulum->id, old('kurikulum_ids', $selectedKurikulumIds))) ? 'checked' : '' }}>
                                        <label for="kurikulum_{{ $kurikulum->id }}" class="ml-2 text-sm text-gray-900">{{ $kurikulum->nama_kurikulum }} ({{ $kurikulum->tahun_mulai }} - {{ $kurikulum->programStudi->nama ?? 'N/A' }})</label> {{-- Menggunakan kolom 'nama' --}}
                                    </div>
                                @empty
                                    <p class="text-sm text-gray-500">Belum ada kurikulum yang tersedia.</p>
                                @endforelse
                            </div>
                            @error('kurikulum_ids')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            @error('kurikulum_ids.*')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.mata-kuliah.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 active:bg-gray-400 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 mr-2">Batal</a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
