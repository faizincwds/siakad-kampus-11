<?php

namespace Database\Seeders;

use App\Models\Kelas;
use App\Models\Semester;
use App\Models\Mahasiswa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KelasMahasiswaSeeder extends Seeder
{
    public function run(): void
    {

        // Menonaktifkan foreign key checks untuk melakukan truncate
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('kelas_mahasiswa')->truncate(); // Kosongkan tabel pivot
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // --- Dapatkan Semester yang Dibutuhkan ---
        // Asumsi: "Ganjil 2023/2024" sudah ada atau kita akan mengambil yang aktif
        $activeSemester = Semester::where('is_active', true)->first();
        // Atau ambil semester spesifik jika Anda ingin data untuk semester non-aktif
        $semesterGanjil2324 = Semester::where('nama_semester', 'Ganjil 2023/2024')->first();
        $semesterGenap2324 = Semester::where('nama_semester', 'Genap 2023/2024')->first();

        if (!$activeSemester || !$semesterGanjil2324 || !$semesterGenap2324) {
            $this->command->warn('Semester yang dibutuhkan untuk KelasMahasiswaSeeder tidak ditemukan. Harap pastikan SemesterSeeder sudah dijalankan dan data semester tersedia.');
            return;
        }

        // --- Mendapatkan Kelas Berdasarkan semester_id ---
        // Perhatikan: Jika nama_kelas bisa sama di semester berbeda, query ini harus lebih spesifik.
        // Asumsi MataKuliah dengan kode_mk 'TI101', 'TI201', 'SI101' sudah ada.

        // Kelas Pemrograman Dasar TI-A (menggunakan semesterGanjil2324)
        $kelasPemrogramanDasarTI_A = Kelas::where('nama_kelas', 'MPI-A')
                                        ->where('semester_id', $semesterGanjil2324->id) // <-- Perubahan penting di sini
                                        ->whereHas('mataKuliah', function ($query) {
                                            $query->where('kode_mk', 'TI101');
                                        })
                                        ->first();

        // Kelas Basis Data TI-A (menggunakan semesterGenap2324)
        $kelasBasisDataTI_A = Kelas::where('nama_kelas', 'MPI-A')
                                    ->where('semester_id', $semesterGenap2324->id) // <-- Perubahan penting di sini
                                    ->whereHas('mataKuliah', function ($query) {
                                        $query->where('kode_mk', 'TI201');
                                    })
                                    ->first();

        // Kelas Pengantar SI Reguler (menggunakan semesterGanjil2324)
        $kelasPengantarSIReguler = Kelas::where('nama_kelas', 'PGMI-Reguler')
                                        ->where('semester_id', $semesterGanjil2324->id) // <-- Perubahan penting di sini
                                        ->whereHas('mataKuliah', function ($query) {
                                            $query->where('kode_mk', 'SI101');
                                        })
                                        ->first();

        // Dapatkan mahasiswa
        $mahasiswaBudi = Mahasiswa::where('nim', '2023001')->first();
        $mahasiswaSiti = Mahasiswa::where('nim', '2023002')->first();
        $mahasiswaJoko = Mahasiswa::where('nim', '2023003')->first();

        // Data pendaftaran mahasiswa ke kelas
        $dataKelasMahasiswa = [];

        if ($kelasPemrogramanDasarTI_A && $mahasiswaBudi) {
            $dataKelasMahasiswa[] = [
                'kelas_id' => $kelasPemrogramanDasarTI_A->id,
                'mahasiswa_id' => $mahasiswaBudi->id,
                'nilai_akhir' => 85.50,
                'status_kelas' => 'Lulus',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if ($kelasPemrogramanDasarTI_A && $mahasiswaSiti) {
            $dataKelasMahasiswa[] = [
                'kelas_id' => $kelasPemrogramanDasarTI_A->id,
                'mahasiswa_id' => $mahasiswaSiti->id,
                'nilai_akhir' => 78.00,
                'status_kelas' => 'Lulus',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if ($kelasBasisDataTI_A && $mahasiswaBudi) {
            $dataKelasMahasiswa[] = [
                'kelas_id' => $kelasBasisDataTI_A->id,
                'mahasiswa_id' => $mahasiswaBudi->id,
                'nilai_akhir' => null, // Belum ada nilai akhir
                'status_kelas' => 'Sedang Berlangsung',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if ($kelasPengantarSIReguler && $mahasiswaSiti) {
            $dataKelasMahasiswa[] = [
                'kelas_id' => $kelasPengantarSIReguler->id,
                'mahasiswa_id' => $mahasiswaSiti->id,
                'nilai_akhir' => 92.00,
                'status_kelas' => 'Lulus',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if ($kelasPengantarSIReguler && $mahasiswaJoko) {
            $dataKelasMahasiswa[] = [
                'kelas_id' => $kelasPengantarSIReguler->id,
                'mahasiswa_id' => $mahasiswaJoko->id,
                'nilai_akhir' => 60.00, // Contoh nilai tidak lulus
                'status_kelas' => 'Tidak Lulus',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Masukkan data ke tabel pivot
        DB::table('kelas_mahasiswa')->insertOrIgnore($dataKelasMahasiswa);
    }


    /**
     * Run the database seeds.
     */
    // public function run(): void
    // {
    //     // Pastikan Anda memiliki data Kelas dan Mahasiswa di database
    //     $kelasPemrogramanDasarTI_A = Kelas::where('nama_kelas', 'MPI-A')
    //                                     ->whereHas('mataKuliah', function ($query) {
    //                                         $query->where('kode_mk', 'TI101');
    //                                     })
    //                                     ->where('tahun_akademik', '2023/2024')
    //                                     ->where('semester_akademik', 'Ganjil')
    //                                     ->first();

    //     $kelasBasisDataTI_A = Kelas::where('nama_kelas', 'MPI-A')
    //                               ->whereHas('mataKuliah', function ($query) {
    //                                   $query->where('kode_mk', 'TI201');
    //                               })
    //                               ->where('tahun_akademik', '2023/2024')
    //                               ->where('semester_akademik', 'Genap')
    //                               ->first();

    //     $kelasPengantarSIReguler = Kelas::where('nama_kelas', 'PGMI-Reguler')
    //                                    ->whereHas('mataKuliah', function ($query) {
    //                                        $query->where('kode_mk', 'SI101');
    //                                    })
    //                                    ->where('tahun_akademik', '2023/2024')
    //                                    ->where('semester_akademik', 'Ganjil')
    //                                    ->first();

    //     $mahasiswaBudi = Mahasiswa::where('nim', '2023001')->first();
    //     $mahasiswaSiti = Mahasiswa::where('nim', '2023002')->first();
    //     $mahasiswaJoko = Mahasiswa::where('nim', '2023003')->first();

    //     // Data pendaftaran mahasiswa ke kelas
    //     $dataKelasMahasiswa = [];

    //     if ($kelasPemrogramanDasarTI_A && $mahasiswaBudi) {
    //         $dataKelasMahasiswa[] = [
    //             'kelas_id' => $kelasPemrogramanDasarTI_A->id,
    //             'mahasiswa_id' => $mahasiswaBudi->id,
    //             'nilai_akhir' => 85.50,
    //             'status_kelas' => 'Lulus',
    //             'created_at' => now(),
    //             'updated_at' => now(),
    //         ];
    //     }

    //     if ($kelasPemrogramanDasarTI_A && $mahasiswaSiti) {
    //         $dataKelasMahasiswa[] = [
    //             'kelas_id' => $kelasPemrogramanDasarTI_A->id,
    //             'mahasiswa_id' => $mahasiswaSiti->id,
    //             'nilai_akhir' => 78.00,
    //             'status_kelas' => 'Lulus',
    //             'created_at' => now(),
    //             'updated_at' => now(),
    //         ];
    //     }

    //     if ($kelasBasisDataTI_A && $mahasiswaBudi) {
    //         $dataKelasMahasiswa[] = [
    //             'kelas_id' => $kelasBasisDataTI_A->id,
    //             'mahasiswa_id' => $mahasiswaBudi->id,
    //             'nilai_akhir' => null, // Belum ada nilai akhir
    //             'status_kelas' => 'Sedang Berlangsung',
    //             'created_at' => now(),
    //             'updated_at' => now(),
    //         ];
    //     }

    //     if ($kelasPengantarSIReguler && $mahasiswaSiti) {
    //         $dataKelasMahasiswa[] = [
    //             'kelas_id' => $kelasPengantarSIReguler->id,
    //             'mahasiswa_id' => $mahasiswaSiti->id,
    //             'nilai_akhir' => 92.00,
    //             'status_kelas' => 'Lulus',
    //             'created_at' => now(),
    //             'updated_at' => now(),
    //         ];
    //     }

    //     if ($kelasPengantarSIReguler && $mahasiswaJoko) {
    //         $dataKelasMahasiswa[] = [
    //             'kelas_id' => $kelasPengantarSIReguler->id,
    //             'mahasiswa_id' => $mahasiswaJoko->id,
    //             'nilai_akhir' => 60.00, // Contoh nilai tidak lulus
    //             'status_kelas' => 'Tidak Lulus',
    //             'created_at' => now(),
    //             'updated_at' => now(),
    //         ];
    //     }

    //     // Masukkan data ke tabel pivot
    //     DB::table('kelas_mahasiswa')->insertOrIgnore($dataKelasMahasiswa);
    // }
}
