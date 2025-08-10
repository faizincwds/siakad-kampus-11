<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail KRS Mahasiswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Informasi KRS') }}</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6 border-b pb-4">
                    <div>
                        <p class="text-sm text-gray-600">{{ __('Mahasiswa:') }} <span class="font-semibold text-gray-900">{{ $krs->mahasiswa->nama_lengkap }} ({{ $krs->mahasiswa->nim }})</span></p>
                        <p class="text-sm text-gray-600">{{ __('Semester:') }} <span class="font-semibold text-gray-900">{{ $krs->semester->tahun_ajaran }} {{ $krs->semester->nama_semester }}</span></p>
                        <p class="text-sm text-gray-600">{{ __('Tanggal Pengajuan:') }} <span class="font-semibold text-gray-900">{{ $krs->tanggal_pengajuan->translatedFormat('d F Y H:i') }}</span></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">{{ __('Status:') }}
                            @php
                                $statusClass = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'approved' => 'bg-green-100 text-green-800',
                                    'rejected' => 'bg-red-100 text-red-800',
                                ][$krs->status] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                {{ ucfirst($krs->status) }}
                            </span>
                        </p>
                        @if($krs->tanggal_persetujuan)
                            <p class="text-sm text-gray-600">{{ __('Tanggal Persetujuan:') }} <span class="font-semibold text-gray-900">{{ $krs->tanggal_persetujuan->translatedFormat('d F Y H:i') }}</span></p>
                            <p class="text-sm text-gray-600">{{ __('Disetujui Oleh:') }} <span class="font-semibold text-gray-900">
                                @if($krs->disetujuiOleh)
                                    {{ $krs->disetujuiOleh->name }} (
                                        @if($krs->disetujuiOleh->role) {{-- Pastikan relasi role ada --}}
                                            {{ ucfirst($krs->disetujuiOleh->role->name) }} {{-- Akses nama role melalui relasi role --}}
                                        @else
                                            N/A Role
                                        @endif
                                    )
                                @else
                                    N/A
                                @endif
                            </span></p>
                        @endif
                        @if($krs->catatan_persetujuan)
                            <p class="text-sm text-gray-600">{{ __('Catatan:') }} <span class="font-semibold text-gray-900">{{ $krs->catatan_persetujuan }}</span></p>
                        @endif
                    </div>
                </div>

                <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Mata Kuliah yang Diambil') }} (Total SKS: {{ $totalSKS }})</h3>
                @if ($krs->details->isEmpty())
                    <p class="text-gray-600">{{ __('Mahasiswa ini belum memilih mata kuliah.') }}</p>
                @else
                    <div class="overflow-x-auto mb-6">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Kode MK') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Mata Kuliah') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('SKS') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Kelas') }}
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
                                @foreach ($krs->details as $detail)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $detail->kelas->mataKuliah->kode_mk }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $detail->kelas->mataKuliah->nama_mk }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $detail->kelas->mataKuliah->sks }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $detail->kelas->nama_kelas }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $detail->kelas->dosen->nama_lengkap }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $detail->kelas->day_name }}, {{ $detail->kelas->start_time->format('H:i') }} - {{ $detail->kelas->end_time->format('H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $detail->kelas->room->name }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                @if ($krs->status === 'pending')
                    <div class="mt-4 flex space-x-4">
                        <form action="{{ route('admin.krs.approve', $krs->id) }}" method="POST" class="inline">
                            @csrf
                            <input type="hidden" name="catatan_persetujuan" value="Disetujui oleh admin."> {{-- Anda bisa menambahkan input textarea untuk catatan --}}
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('Setujui KRS') }}
                            </button>
                        </form>

                        <button type="button" onclick="openRejectModal()" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150">
                            {{ __('Tolak KRS') }}
                        </button>
                    </div>
                @endif

                <div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
                    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                        <div class="mt-3 text-center">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ __('Tolak Pengajuan KRS') }}</h3>
                            <div class="mt-2 px-7 py-3">
                                <form action="{{ route('admin.krs.reject', $krs->id) }}" method="POST">
                                    @csrf
                                    <label for="catatan_penolakan" class="block text-sm font-medium text-gray-700 text-left mb-1">{{ __('Catatan Penolakan:') }}</label>
                                    <textarea name="catatan_persetujuan" id="catatan_penolakan" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required></textarea>
                                    <p class="text-xs text-gray-500 mt-1 text-left">{{ __('Wajib mengisi alasan penolakan.') }}</p>

                                    <div class="items-center px-4 py-3">
                                        <button type="submit" class="px-4 py-2 bg-red-600 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                                            {{ __('Kirim Penolakan') }}
                                        </button>
                                        <button type="button" onclick="closeRejectModal()" class="mt-3 px-4 py-2 bg-gray-200 text-gray-800 text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-300">
                                            {{ __('Batal') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    function openRejectModal() {
                        document.getElementById('rejectModal').classList.remove('hidden');
                    }

                    function closeRejectModal() {
                        document.getElementById('rejectModal').classList.add('hidden');
                    }

                    // Close modal when clicking outside
                    window.onclick = function(event) {
                        const modal = document.getElementById('rejectModal');
                        if (event.target == modal) {
                            modal.classList.add('hidden');
                        }
                    }
                </script>

            </div>
        </div>
    </div>
</x-app-layout>
