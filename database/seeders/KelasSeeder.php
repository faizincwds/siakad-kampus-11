<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\Dosen;
use App\Models\Kelas;
use App\Models\Semester;
use App\Models\MataKuliah;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Database\Seeders\RoomSeeder;
use Database\Seeders\DosenSeeder;
use Illuminate\Support\Facades\DB;
use Database\Seeders\SemesterSeeder;
use Database\Seeders\MataKuliahSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        // Pastikan ada data di tabel lain yang dibutuhkan
        if (MataKuliah::count() === 0) {
            $this->call(MataKuliahSeeder::class); // Panggil MataKuliahSeeder jika belum ada data
        }
        if (Dosen::count() === 0) {
            $this->call(DosenSeeder::class); // Panggil DosenSeeder
        }
        if (Room::count() === 0) {
            $this->call(RoomSeeder::class); // Panggil RoomSeeder
        }
        if (Semester::count() === 0) {
            $this->call(SemesterSeeder::class); // Panggil SemesterSeeder jika belum ada
        }

        // Dapatkan ID semester yang aktif
        $activeSemester = Semester::where('is_active', true)->first();

        if (!$activeSemester) {
            $this->command->warn('Tidak ada semester aktif ditemukan. Lewati seeding kelas.');
            return;
        }

        // Dapatkan beberapa ID dari tabel lain secara acak
        $mataKuliahIds = MataKuliah::pluck('id')->toArray();
        $dosenIds = Dosen::pluck('id')->toArray();
        $roomIds = Room::pluck('id')->toArray();
        // $daysOfWeek = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

        DB::statement('SET FOREIGN_KEY_CHECKS=0;'); // Nonaktifkan foreign key checks
        DB::table('kelas_mahasiswa')->truncate(); // Hapus data di pivot table terlebih dahulu
        Kelas::truncate(); // Hapus semua data di tabel kelas
        DB::statement('SET FOREIGN_KEY_CHECKS=1;'); // Aktifkan kembali foreign key checks

        // Hapus kelas yang ada agar tidak duplikat saat seeding ulang
        // Kelas::truncate(); // Gunakan ini HANYA jika Anda ingin menghapus semua data kelas yang ada

        // Contoh data kelas
        $kelasData = [
            [
                'nama_kelas' => 'Basis Data - A',
                'mata_kuliah_id' => $mataKuliahIds[array_rand($mataKuliahIds)],
                'dosen_id' => $dosenIds[array_rand($dosenIds)],
                'room_id' => $roomIds[array_rand($roomIds)],
                'day_of_week' => 'Senin',
                'start_time' => '08:00:00',
                'end_time' => '09:30:00',
                'semester_id' => $activeSemester->id,
            ],
            [
                'nama_kelas' => 'Pemrograman Web - B',
                'mata_kuliah_id' => $mataKuliahIds[array_rand($mataKuliahIds)],
                'dosen_id' => $dosenIds[array_rand($dosenIds)],
                'room_id' => $roomIds[array_rand($roomIds)],
                'day_of_week' => 'Selasa',
                'start_time' => '10:00:00',
                'end_time' => '11:30:00',
                'semester_id' => $activeSemester->id,
            ],
            // Tambahkan lebih banyak data kelas sesuai kebutuhan Anda
        ];

        foreach ($kelasData as $data) {
            // Tambahkan ID UUID secara manual
            $data['id'] = Str::uuid();
            Kelas::create($data);
        }
    }

    // public function run(): void
    // {

    //     // Pastikan Anda memiliki data Mata Kuliah, Dosen, dan Ruangan di database
    //     // Jika belum, Anda perlu membuat Seeder untuk MataKuliah, Dosen, dan Room
    //     // atau memasukkan data ini melalui RolesAndPermissionsSeeder jika relevan.

    //     // Cari data Mata Kuliah yang sudah ada
    //     $mkPemrogramanDasar = MataKuliah::where('kode_mk', 'TI101')->first(); // Gunakan 'kode_mk'
    //     $mkBasisData = MataKuliah::where('kode_mk', 'TI201')->first(); // Gunakan 'kode_mk'
    //     $mkPengantarSI = MataKuliah::where('kode_mk', 'SI101')->first(); // Gunakan 'kode_mk'

    //     // Cari data Dosen yang sudah ada
    //     $dosenAhmad = Dosen::where('nidn', '0011038501')->first();
    //     $dosenSiti = Dosen::where('nidn', '0022079002')->first();

    //     // Cari data Ruangan yang sudah ada (Anda mungkin perlu menambahkan RoomsSeeder atau buat beberapa data di sini)
    //     $roomLabKomputer1 = Room::where('code', 'LK1')->first(); // Asumsi ada ruangan dengan kode LK1
    //     $roomTeoriA = Room::where('code', 'RTA')->first(); // Asumsi ada ruangan dengan kode RTA
    //     $roomAuditorium = Room::where('code', 'AUD')->first(); // Asumsi ada ruangan dengan kode AUD

    //     // Cek apakah data master ditemukan sebelum melanjutkan
    //     if (!$mkPemrogramanDasar || !$mkBasisData || !$mkPengantarSI || !$dosenAhmad || !$dosenSiti || !$roomLabKomputer1 || !$roomTeoriA || !$roomAuditorium) {
    //         $this->command->warn('Data master (Mata Kuliah, Dosen, atau Ruangan) tidak ditemukan. Mohon pastikan seeders mereka sudah dijalankan.');
    //         $this->command->warn('Akan mencoba melanjutkan, tetapi beberapa kelas mungkin tidak dibuat.');
    //         // Anda bisa tambahkan logika untuk membuat data default di sini jika tidak ditemukan,
    //         // atau hentikan proses seeder ini.
    //         return; // Hentikan jika data penting tidak ada
    //     }


    //     // Data Kelas yang akan diisi
    //     $dataKelas = [
    //         [
    //             'nama_kelas' => 'Pemrograman Dasar - A',
    //             'semester_id' =>
    //             'mata_kuliah_id' => $mkPemrogramanDasar->id,
    //             'dosen_id' => $dosenAhmad->id,
    //             'room_id' => $roomLabKomputer1->id, // Tambahkan ruangan
    //             'day_of_week' => 'Monday', // Hari
    //             'start_time' => '08:00:00', // Jam mulai
    //             'end_time' => '10:00:00', // Jam selesai

    //         ],
    //         [
    //             'nama_kelas' => 'Basis Data - B',
    //             'tahun_akademik' => '2023/2024',
    //             'semester_akademik' => 'Ganjil',
    //             'mata_kuliah_id' => $mkBasisData->id,
    //             'dosen_id' => $dosenSiti->id,
    //             'room_id' => $roomTeoriA->id, // Tambahkan ruangan
    //             'day_of_week' => 'Tuesday', // Hari
    //             'start_time' => '10:30:00', // Jam mulai
    //             'end_time' => '12:30:00', // Jam selesai
    //         ],
    //         [
    //             'nama_kelas' => 'Basis Data - A', // Nama kelas bisa sama, tapi jadwal berbeda
    //             'tahun_akademik' => '2023/2024',
    //             'semester_akademik' => 'Genap',
    //             'mata_kuliah_id' => $mkBasisData->id,
    //             'dosen_id' => $dosenAhmad->id,
    //             'room_id' => $roomLabKomputer1->id, // Ruangan sama
    //             'day_of_week' => 'Wednesday', // Hari berbeda
    //             'start_time' => '09:00:00', // Jam berbeda
    //             'end_time' => '11:00:00',
    //         ],
    //         [
    //             'nama_kelas' => 'Pengantar SI - Reguler',
    //             'tahun_akademik' => '2023/2024',
    //             'semester_akademik' => 'Ganjil',
    //             'mata_kuliah_id' => $mkPengantarSI->id,
    //             'dosen_id' => $dosenSiti->id,
    //             'room_id' => $roomAuditorium->id, // Tambahkan ruangan
    //             'day_of_week' => 'Thursday', // Hari
    //             'start_time' => '13:00:00', // Jam mulai
    //             'end_time' => '15:00:00', // Jam selesai
    //         ],
    //         // Tambahkan data kelas lain sesuai kebutuhan Anda
    //     ];

    //     foreach ($dataKelas as $kelasData) {
    //         // Gunakan firstOrCreate untuk mencegah duplikasi berdasarkan kombinasi unik jadwal
    //         // Sesuaikan kriteria unik ini agar sesuai dengan unique constraint di migrasi kelas
    //         Kelas::firstOrCreate([
    //             'room_id' => $kelasData['room_id'],
    //             'day_of_week' => $kelasData['day_of_week'],
    //             'start_time' => $kelasData['start_time'],
    //             'end_time' => $kelasData['end_time'],
    //             'tahun_akademik' => $kelasData['tahun_akademik'],
    //             'semester_akademik' => $kelasData['semester_akademik'],
    //             // Pastikan 'nama_kelas', 'mata_kuliah_id', 'dosen_id' juga disertakan jika merupakan bagian dari unique constraint
    //             // Jika unique constraint di migrasi hanya berdasarkan waktu dan ruangan, cukup itu saja di firstOrCreate
    //         ], $kelasData);
    //     }

    //     $this->command->info('Data Kelas/Jadwal berhasil di-seed.');
    // }


    // public function run(): void
    // {
    //     // Pastikan Anda memiliki data Mata Kuliah dan Dosen di database
    //     $mkPemrogramanDasar = MataKuliah::where('kode_mk', 'TI101')->first();
    //     $mkBasisData = MataKuliah::where('kode_mk', 'TI201')->first();
    //     $mkPengantarSI = MataKuliah::where('kode_mk', 'SI101')->first();

    //     $dosenAhmad = Dosen::where('nidn', '0011038501')->first();
    //     $dosenSiti = Dosen::where('nidn', '0022079002')->first();

    //     // Data Kelas yang akan diisi
    //     $dataKelas = [
    //         [
    //             'nama_kelas' => 'MPI-A',
    //             'tahun_akademik' => '2023/2024',
    //             'semester_akademik' => 'Ganjil',
    //             'mata_kuliah_id' => $mkPemrogramanDasar->id,
    //             'dosen_id' => $dosenAhmad->id,
    //         ],
    //         [
    //             'nama_kelas' => 'MPI-B',
    //             'tahun_akademik' => '2023/2024',
    //             'semester_akademik' => 'Ganjil',
    //             'mata_kuliah_id' => $mkBasisData->id,
    //             'dosen_id' => $dosenSiti->id,
    //         ],
    //         [
    //             'nama_kelas' => 'MPI-A',
    //             'tahun_akademik' => '2023/2024',
    //             'semester_akademik' => 'Genap',
    //             'mata_kuliah_id' => $mkBasisData->id,
    //             'dosen_id' => $dosenAhmad->id,
    //         ],
    //         [
    //             'nama_kelas' => 'PGMI-Reguler',
    //             'tahun_akademik' => '2023/2024',
    //             'semester_akademik' => 'Ganjil',
    //             'mata_kuliah_id' => $mkPengantarSI->id,
    //             'dosen_id' => $dosenSiti->id,
    //         ],
    //         // Tambahkan data kelas lain sesuai kebutuhan
    //     ];

    //     foreach ($dataKelas as $kelasData) {
    //         // Gunakan firstOrCreate untuk mencegah duplikasi
    //         Kelas::firstOrCreate([
    //             'mata_kuliah_id' => $kelasData['mata_kuliah_id'],
    //             'nama_kelas' => $kelasData['nama_kelas'],
    //             'tahun_akademik' => $kelasData['tahun_akademik'],
    //             'semester_akademik' => $kelasData['semester_akademik'],
    //         ], $kelasData);
    //     }
    // }
}
