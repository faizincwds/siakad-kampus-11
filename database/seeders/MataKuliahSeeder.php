<?php

namespace Database\Seeders;

use App\Models\MataKuliah;
use App\Models\ProgramStudi;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MataKuliahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan Anda memiliki data Program Studi di database
        $mpi = ProgramStudi::where('kode', 'MPI')->first();
        $pgmi = ProgramStudi::where('kode', 'PGMI')->first();

        // Data Mata Kuliah yang akan diisi
        $dataMataKuliah = [
            // Mata Kuliah untuk Teknik Informatika (TI)
            [
                'kode_mk' => 'TI101',
                'nama_mk' => 'Pemrograman Dasar',
                'sks' => 3,
                'semester' => '1',
                'jenis_mata_kuliah' => 'Wajib',
                'deskripsi' => 'Pengenalan konsep dasar pemrograman menggunakan bahasa Python.',
                'program_studi_id' => $mpi->id ?? null,
            ],
            [
                'kode_mk' => 'TI102',
                'nama_mk' => 'Algoritma dan Struktur Data',
                'sks' => 3,
                'semester' => '2',
                'jenis_mata_kuliah' => 'Pilihan',
                'deskripsi' => 'Mempelajari berbagai algoritma dan struktur data fundamental.',
                'program_studi_id' => $mpi->id ?? null,
            ],
            [
                'kode_mk' => 'TI201',
                'nama_mk' => 'Basis Data',
                'sks' => 3,
                'semester' => '3',
                'jenis_mata_kuliah' => 'Wajib',
                'deskripsi' => 'Konsep dan implementasi sistem manajemen basis data relasional.',
                'program_studi_id' => $mpi->id ?? null,
            ],
            [
                'kode_mk' => 'TI202',
                'nama_mk' => 'Pemrograman Web',
                'sks' => 3,
                'semester' => '4',
                'jenis_mata_kuliah' => 'Pilihan',
                'deskripsi' => 'Pengembangan aplikasi web menggunakan framework modern.',
                'program_studi_id' => $mpi->id ?? null,
            ],

            // Mata Kuliah untuk Sistem Informasi (SI)
            [
                'kode_mk' => 'SI101',
                'nama_mk' => 'Pengantar Sistem Informasi',
                'sks' => 3,
                'semester' => '1',
                'deskripsi' => 'Memahami peran sistem informasi dalam organisasi.',
                'program_studi_id' => $pgmi->id ?? null,
            ],
            [
                'kode_mk' => 'SI201',
                'nama_mk' => 'Analisis dan Perancangan Sistem',
                'sks' => 3,
                'semester' => '3',
                'deskripsi' => 'Metodologi analisis dan perancangan sistem informasi.',
                'program_studi_id' => $pgmi->id ?? null,
            ],

            // Mata Kuliah untuk Manajemen (MNJ)
            [
                'kode_mk' => 'MNJ101',
                'nama_mk' => 'Pengantar Manajemen',
                'sks' => 3,
                'semester' => '1',
                'deskripsi' => 'Konsep dasar manajemen dan fungsi-fungsi manajemen.',
                'program_studi_id' => $mpi->id ?? null,
            ],

            // Mata Kuliah untuk Ilmu Hukum (IH)
            [
                'kode_mk' => 'IH101',
                'nama_mk' => 'Pengantar Ilmu Hukum',
                'sks' => 3,
                'semester' => '1',
                'deskripsi' => 'Dasar-dasar ilmu hukum dan sistem hukum di Indonesia.',
                'program_studi_id' => $pgmi->id ?? null,
            ],
            // Tambahkan data mata kuliah lain sesuai kebutuhan
        ];

        foreach ($dataMataKuliah as $mk) {
            // Gunakan firstOrCreate untuk mencegah duplikasi
            MataKuliah::firstOrCreate(['kode_mk' => $mk['kode_mk']], $mk);
        }
    }
}
