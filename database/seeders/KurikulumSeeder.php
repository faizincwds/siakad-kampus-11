<?php

namespace Database\Seeders;

use App\Models\Kurikulum;
use App\Models\ProgramStudi;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KurikulumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan Anda memiliki data Program Studi di database
        $mpi = ProgramStudi::where('kode', 'MPI')->first();
        $pgmi = ProgramStudi::where('kode', 'PGMI')->first();

        // Data Kurikulum yang akan diisi
        $dataKurikulum = [
            [
                'nama_kurikulum' => 'Kurikulum 2017 Manajemen Pendidikan Islam',
                'tahun_mulai' => '2017',
                'tahun_selesai' => '2023', // Masih berlaku
                'deskripsi' => 'Kurikulum lama untuk Program Studi Manajemen Pendidikan Islam.',
                'program_studi_id' => $mpi->id ?? null,
                'is_aktif' => false,
            ],
            [
                'nama_kurikulum' => 'Kurikulum 2024 Manajemen Pendidikan Islam',
                'tahun_mulai' => '2024',
                'tahun_selesai' => null, // Masih berlaku
                'deskripsi' => 'Kurikulum terbaru untuk Program Studi Manajemen Pendidikan Islam.',
                'program_studi_id' => $pgmi->id ?? null,
                'is_aktif' => true,
            ],
            [
                'nama_kurikulum' => 'Kurikulum 2017 Pendidikan Guru Madrasah Ibtidaiyah',
                'tahun_mulai' => '2017',
                'tahun_selesai' => '2023', // Sudah tidak berlaku
                'deskripsi' => 'Kurikulum lama untuk Program Studi Pendidikan Guru Madrasah Ibtidaiyah.',
                'program_studi_id' => $pgmi->id ?? null,
                'is_aktif' => false,
            ],
            [
                'nama_kurikulum' => 'Kurikulum 2024 Pendidikan Guru Madrasah Ibtidaiyah',
                'tahun_mulai' => '2024',
                'tahun_selesai' => null, // Masih berlaku
                'deskripsi' => 'Kurikulum baru untuk Program Studi Pendidikan Guru Madrasah Ibtidaiyah mulai angkatan 2024.',
                'program_studi_id' => $mpi->id ?? null,
                'is_aktif' => true,
            ],
            // Tambahkan data kurikulum lain sesuai kebutuhan
        ];

        foreach ($dataKurikulum as $kurikulum) {
            // Gunakan firstOrCreate untuk mencegah duplikasi berdasarkan program_studi_id dan tahun_mulai
            Kurikulum::firstOrCreate([
                'program_studi_id' => $kurikulum['program_studi_id'],
                'tahun_mulai' => $kurikulum['tahun_mulai'],
            ], $kurikulum);
        }
    }
}
