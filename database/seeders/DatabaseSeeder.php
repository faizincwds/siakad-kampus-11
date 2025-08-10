<?php

namespace Database\Seeders;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       // \App\Models\User::factory(10)->create();

        $this->call([
            RoleSeeder::class, // Panggil seeder peran
            UserSeeder::class, // Kemudian panggil seeder user
            FakultasSeeder::class, // Panggil seeder Fakultas di sini
            ProgramStudiSeeder::class, // Panggil seeder Program Studi di sini
            SemesterSeeder::class,
            KurikulumSeeder::class, // Panggil seeder Kurikulum
            KurikulumMataKuliahSeeder::class, // Panggil seeder KurikulumMataKuliah
            MahasiswaSeeder::class,   // MahasiswaSeeder dijalankan terakhir untuk mengaitkan user
            DosenSeeder::class,         // DosenSeeder dijalankan terakhir untuk mengaitkan user
            MataKuliahSeeder::class, // Panggil seeder Mata Kuliah di sini
            RolesAndPermissionsSeeder::class,
            RoomSeeder::class,
            KelasSeeder::class, // Panggil seeder Kelas di sini
            KrsSeeder::class, // KRS harus ada sebelum KRSDetail
            KrsDetailSeeder::class,
            KelasMahasiswaSeeder::class, // Panggil seeder KelasMahasiswa

            // Nanti kita akan panggil seeder lain di sini
        ]);
    }
}
