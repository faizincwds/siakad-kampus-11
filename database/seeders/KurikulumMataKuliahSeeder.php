<?php

namespace Database\Seeders;

use App\Models\Kurikulum;
use App\Models\MataKuliah;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KurikulumMataKuliahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan Anda memiliki data Kurikulum dan Mata Kuliah di database
        // Ambil Kurikulum
        $kurikulumMPI2017 = Kurikulum::where('nama_kurikulum', 'Kurikulum 2017 Manajemen Pendidikan Islam')->first();
        $kurikulumMPI2024 = Kurikulum::where('nama_kurikulum', 'Kurikulum 2024 Manajemen Pendidikan Islam')->first();
        $kurikulumPGMI2017 = Kurikulum::where('nama_kurikulum', 'Kurikulum 2017 Pendidikan Guru Madrasah Ibtidaiyah')->first();
        $kurikulumPGMI2024 = Kurikulum::where('nama_kurikulum', 'Kurikulum 2024 Pendidikan Guru Madrasah Ibtidaiyah')->first();

        // Ambil Mata Kuliah
        $mkPemrogramanDasar = MataKuliah::where('kode_mk', 'TI101')->first();
        $mkAlgoritmaSD = MataKuliah::where('kode_mk', 'TI102')->first();
        $mkBasisData = MataKuliah::where('kode_mk', 'TI201')->first();
        $mkPemrogramanWeb = MataKuliah::where('kode_mk', 'TI202')->first();
        $mkPengantarSI = MataKuliah::where('kode_mk', 'SI101')->first();
        $mkAnalisisPS = MataKuliah::where('kode_mk', 'SI201')->first();
        $mkPengantarManajemen = MataKuliah::where('kode_mk', 'MNJ101')->first();
        $mkPengantarIlmuHukum = MataKuliah::where('kode_mk', 'IH101')->first();


        // Data pendaftaran mata kuliah ke kurikulum
        $dataKurikulumMataKuliah = [];

        // Kurikulum 2017 MPI
        if ($kurikulumMPI2017 && $mkPemrogramanDasar) {
            $dataKurikulumMataKuliah[] = [
                'kurikulum_id' => $kurikulumMPI2017->id,
                'mata_kuliah_id' => $mkPemrogramanDasar->id,
                'semester_ditawarkan' => '1',
                'status_mk' => 'Wajib',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        if ($kurikulumMPI2017 && $mkAlgoritmaSD) {
            $dataKurikulumMataKuliah[] = [
                'kurikulum_id' => $kurikulumMPI2017->id,
                'mata_kuliah_id' => $mkAlgoritmaSD->id,
                'semester_ditawarkan' => '2',
                'status_mk' => 'Wajib',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        if ($kurikulumMPI2017 && $mkBasisData) {
            $dataKurikulumMataKuliah[] = [
                'kurikulum_id' => $kurikulumMPI2017->id,
                'mata_kuliah_id' => $mkBasisData->id,
                'semester_ditawarkan' => '3',
                'status_mk' => 'Wajib',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        if ($kurikulumMPI2017 && $mkPemrogramanWeb) {
            $dataKurikulumMataKuliah[] = [
                'kurikulum_id' => $kurikulumMPI2017->id,
                'mata_kuliah_id' => $mkPemrogramanWeb->id,
                'semester_ditawarkan' => '4',
                'status_mk' => 'Wajib',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        // Contoh mata kuliah pilihan di Kurikulum MPI
        if ($kurikulumMPI2017 && $mkPengantarIlmuHukum) { // Misal bisa diambil sebagai MK pilihan
             $dataKurikulumMataKuliah[] = [
                'kurikulum_id' => $kurikulumMPI2017->id,
                'mata_kuliah_id' => $mkPengantarIlmuHukum->id,
                'semester_ditawarkan' => '6', // Semester ganjil/genap bisa tergantung pilihan
                'status_mk' => 'Pilihan',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Kurikulum 2024 MPI
        if ($kurikulumMPI2024 && $mkPengantarSI) {
            $dataKurikulumMataKuliah[] = [
                'kurikulum_id' => $kurikulumMPI2024->id,
                'mata_kuliah_id' => $mkPengantarSI->id,
                'semester_ditawarkan' => '1',
                'status_mk' => 'Wajib',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        if ($kurikulumMPI2024 && $mkAnalisisPS) {
            $dataKurikulumMataKuliah[] = [
                'kurikulum_id' => $kurikulumMPI2024->id,
                'mata_kuliah_id' => $mkAnalisisPS->id,
                'semester_ditawarkan' => '3',
                'status_mk' => 'Wajib',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Kurikulum 2021 PGMI
        if ($kurikulumPGMI2017 && $mkPengantarManajemen) {
            $dataKurikulumMataKuliah[] = [
                'kurikulum_id' => $kurikulumPGMI2017->id,
                'mata_kuliah_id' => $mkPengantarManajemen->id,
                'semester_ditawarkan' => '1',
                'status_mk' => 'Wajib',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Kurikulum 2024 PGMI
        if ($kurikulumPGMI2024 && $mkPengantarManajemen) {
            $dataKurikulumMataKuliah[] = [
                'kurikulum_id' => $kurikulumPGMI2024->id,
                'mata_kuliah_id' => $mkPengantarManajemen->id,
                'semester_ditawarkan' => '1',
                'status_mk' => 'Wajib',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Masukkan data ke tabel pivot
        DB::table('kurikulum_mata_kuliah')->insertOrIgnore($dataKurikulumMataKuliah);
    }
}
