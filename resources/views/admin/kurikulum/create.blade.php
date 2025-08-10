<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Kurikulum Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">Form Tambah Kurikulum</h3>

                    <form action="{{ route('admin.kurikulum.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="nama_kurikulum" class="block text-sm font-medium text-gray-700">Nama Kurikulum:</label>
                            <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('nama_kurikulum') border-red-500 @enderror" id="nama_kurikulum" name="nama_kurikulum" value="{{ old('nama_kurikulum') }}" required>
                            @error('nama_kurikulum')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="program_studi_id" class="block text-sm font-medium text-gray-700">Program Studi:</label>
                            <select class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('program_studi_id') border-red-500 @enderror" id="program_studi_id" name="program_studi_id" required>
                                <option value="">Pilih Program Studi</option>
                                @foreach ($programStudis as $prodi)
                                    <option value="{{ $prodi->id }}" {{ old('program_studi_id') == $prodi->id ? 'selected' : '' }}>{{ $prodi->nama }}</option> {{-- Menggunakan kolom 'nama' --}}
                                @endforeach
                            </select>
                            @error('program_studi_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="tahun_mulai" class="block text-sm font-medium text-gray-700">Tahun Mulai:</label>
                            <input type="number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('tahun_mulai') border-red-500 @enderror" id="tahun_mulai" name="tahun_mulai" value="{{ old('tahun_mulai', date('Y')) }}" required min="1900" max="{{ date('Y') + 5 }}">
                            @error('tahun_mulai')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="tahun_selesai" class="block text-sm font-medium text-gray-700">Tahun Selesai (Opsional):</label>
                            <input type="number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('tahun_selesai') border-red-500 @enderror" id="tahun_selesai" name="tahun_selesai" value="{{ old('tahun_selesai') }}" min="{{ date('Y') }}" max="{{ date('Y') + 10 }}">
                            @error('tahun_selesai')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi (Opsional):</label>
                            <textarea class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('deskripsi') border-red-500 @enderror" id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <div class="flex items-center">
                                <input type="checkbox" name="is_aktif" id="is_aktif" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ old('is_aktif') ? 'checked' : '' }}>
                                <label for="is_aktif" class="ml-2 block text-sm text-gray-900">
                                    Aktifkan Kurikulum ini (akan menonaktifkan kurikulum lain di program studi yang sama)
                                </label>
                            </div>
                            @error('is_aktif')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.kurikulum.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 active:bg-gray-400 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 mr-2">Batal</a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
