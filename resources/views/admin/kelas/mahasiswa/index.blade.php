<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Mahasiswa Kelas') }} - {{ $kelas->nama_kelas }} ({{ $kelas->mataKuliah->nama_mk }}) {{-- Menggunakan $kelas --}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900">
                            Daftar Mahasiswa Terdaftar
                        </h3>
                        <x-secondary-button>
                            <a href="{{ route('admin.kelas.show', ['kela' => $kelas->id]) }}">
                                {{ __('Kembali') }}
                            </a>
                        </x-secondary-button>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mb-6">
                        <h4 class="text-md font-medium text-gray-800 mb-2">Tambahkan Mahasiswa Baru ke Kelas Ini</h4>
                        <form action="{{ route('admin.kelas.mahasiswa.store', $kelas->id) }}" method="POST" class="flex items-end space-x-4"> {{-- Menggunakan $kelas --}}
                            @csrf
                            <div class="flex-grow">
                                <x-input-label for="mahasiswa_id" :value="__('Pilih Mahasiswa')" />
                                <x-forms.select-input id="mahasiswa_id" name="mahasiswa_id" class="block mt-1 w-full" required
                                    :options="$availableMahasiswa->pluck('nama_lengkap', 'id')->prepend('Pilih Mahasiswa', '')->toArray()"
                                    :value="old('mahasiswa_id')"
                                />
                                <x-input-error :messages="$errors->get('mahasiswa_id')" class="mt-2" />
                            </div>
                            <div>
                                <x-primary-button type="submit"     >
                                    {{ __('Tambahkan') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIM</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Mahasiswa</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai Akhir</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Kelas</th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Aksi</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($kelas->mahasiswas as $mahasiswa) {{-- Menggunakan $kelas --}}
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $mahasiswa->nim }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $mahasiswa->nama_lengkap }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{-- Form untuk update nilai --}}
                                        <form action="{{ route('admin.kelas.mahasiswa.updateNilai', ['kela' => $kelas->id, 'mahasiswa' => $mahasiswa->id]) }}" method="POST" class="flex items-center">
                                            @csrf
                                            @method('PUT')
                                            <x-text-input
                                                id="nilai_akhir_{{ $mahasiswa->id }}" type="number" step="0.01" min="0" max="100" name="nilai_akhir" value="{{ old('nilai_akhir', $mahasiswa->pivot->nilai_akhir) }}" class="w-24 text-sm"
                                            />
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{-- Form untuk update status --}}
                                            <x-forms.select-input
                                                id="status_kelas_{{ $mahasiswa->id }}"
                                                name="status_kelas"
                                                class="w-40 text-sm"
                                                :value="old('status_kelas', $mahasiswa->pivot->status_kelas)"
                                                :options="[
                                                    'Sedang Berlangsung' => 'Sedang Berlangsung',
                                                    'Lulus' => 'Lulus',
                                                    'Tidak Lulus' => 'Tidak Lulus',
                                                    'Mengulang' => 'Mengulang',
                                                ]"
                                            />
                                            <x-primary-button type="submit" class="ml-2 py-1 px-2 text-xs">Update</x-primary-button>
                                        </form>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <form action="{{ route('admin.kelas.mahasiswa.destroy', ['kela' => $kelas->id, 'mahasiswa' => $mahasiswa->id]) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus mahasiswa ini dari kelas?');"> {{-- Menggunakan $kelas --}}
                                            @csrf
                                            @method('DELETE')
                                            <x-danger-button type="submit">
                                                {{ __('Hapus') }}
                                            </x-danger-button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                        Belum ada mahasiswa yang terdaftar di kelas ini.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
