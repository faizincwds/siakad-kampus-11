<?php

namespace Database\Seeders;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tambahkan peran dasar
        Role::create([
            'name' => 'admin',
            'description' => 'Administrator Sistem dengan akses penuh.'
        ]);

        Role::create([
            'name' => 'mahasiswa',
            'description' => 'Pengguna mahasiswa.'
        ]);

        Role::create([
            'name' => 'dosen',
            'description' => 'Pengguna dosen/pengajar.'
        ]);

        Role::create([
            'name' => 'keuangan',
            'description' => 'Pengguna bagian keuangan.'
        ]);
    }
}
