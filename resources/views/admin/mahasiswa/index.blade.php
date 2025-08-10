@extends('layouts.app')

@section('title', 'Mahasiswa')
@section('x-data', 'mahasiswa')

@section('content')
    <div class="rounded-2xl border border-gray-200 bg-white px-2 py-7 dark:border-gray-800 dark:bg-white/[0.03] xl:px-10 xl:py-12">

            <div class="shadow-sm sm:rounded-lg">
                <div class="p-4 text-gray-900">
                    <div class="flex flex-col gap-5 mb-2 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                                Daftar Mahasiswa
                            </h3>
                            </div>

                            <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                            <div>
                                <a href="{{ route('admin.mahasiswa.create') }}"  class="text-theme-sm shadow-theme-xs inline-flex h-8 items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200">
                                Tambah
                                </a>
                            </div>
                            </div>
                        </div>

                    <div class="border-t border-gray-100 pt-4 sm:p-6 dark:border-gray-800">

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <div class="max-w-full overflow-x-auto custom-scrollbar">
                        <table class="min-w-full divide-y divide-gray-200 ">
                            <thead class="border-gray-100 border-y bg-gray-50 dark:border-gray-800 dark:bg-gray-900">
                                <tr>
                                    <th scope="col" class="px-1 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        No
                                    </th>
                                    <th scope="col" class="px-1 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama
                                    </th>
                                    <th scope="col" class="px-1 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        NIM
                                    </th>
                                    <th scope="col" class="px-1 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Jenis Kelamin
                                    </th>
                                    <th scope="col" class="px-1 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Program Studi
                                    </th>
                                    <th scope="col" class="px-1 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-800 dark:text-gray-400" >
                                @forelse ($mahasiswa as $mhs)
                                    <tr>
                                        <td class="px-1 py-3 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 dark:text-gray-400">{{ $loop->iteration }}</div>
                                        </td>
                                        <td class="px-1 py-3 whitespace-nowrap">
                                            <a href="{{ route('admin.mahasiswa.show', $mhs->id) }}" class="">
                                                <div class="text-sm dark:text-indigo-600 text-indigo-600 hover:text-gray-800 dark:hover:text-white">{{ $mhs->nama_lengkap }}</div>
                                            </a>
                                        </td>
                                        <td class="px-1 py-3 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 dark:text-gray-400">{{ $mhs->nim }}</div>
                                        </td>
                                        <td class="px-1 py-3 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 dark:text-gray-400">{{ $mhs->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</div>
                                        </td>
                                        <td class="px-1 py-3 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 dark:text-gray-400">{{ $mhs->programStudi->nama ?? '-' }}</div>
                                        </td>
                                        <td class="px-1 py-3 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('admin.mahasiswa.edit', $mhs->id) }}" class="text-yellow-600 hover:text-yellow-900 mr-2">Edit</a>
                                            <form action="{{ route('admin.mahasiswa.destroy', $mhs->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus Mahasiswa ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                            Belum ada data mahasiswa.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

    </div>

@endsection
