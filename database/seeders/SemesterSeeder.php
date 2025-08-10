<?php

namespace Database\Seeders;

use App\Models\Semester;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SemesterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan hanya satu semester yang aktif
        Semester::query()->update(['is_active' => false]);

        // Tambahkan beberapa data semester
        $semestersData = [
            [
                'id' => Str::uuid(),
                'nama_semester' => 'Ganjil 2023/2024',
                'tahun_akademik' => '2023/2024',
                'jenis_semester' => 'Ganjil',
                'is_active' => false, // Awalnya tidak aktif
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'nama_semester' => 'Genap 2023/2024',
                'tahun_akademik' => '2023/2024',
                'jenis_semester' => 'Genap',
                'is_active' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'nama_semester' => 'Ganjil 2024/2025',
                'tahun_akademik' => '2024/2025',
                'jenis_semester' => 'Ganjil',
                'is_active' => true, // <-- SET INI SEBAGAI AKTIF
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'nama_semester' => 'Genap 2024/2025',
                'tahun_akademik' => '2024/2025',
                'jenis_semester' => 'Genap',
                'is_active' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'nama_semester' => 'Ganjil 2025/2026',
                'tahun_akademik' => '2025/2026',
                'jenis_semester' => 'Ganjil',
                'is_active' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($semestersData as $data) {
            Semester::firstOrCreate(
                ['nama_semester' => $data['nama_semester']], // Cek berdasarkan nama semester agar tidak duplikat
                $data
            );
        }

        // Opsional: Pastikan hanya satu yang aktif setelah seed
        // Jika ada lebih dari satu, ambil yang terakhir di-seed sebagai aktif
        // Atau Anda bisa secara manual mengubah 'is_active' menjadi true untuk salah satu di atas
        // Seperti yang saya lakukan untuk 'Ganjil 2024/2025'
    }
}
