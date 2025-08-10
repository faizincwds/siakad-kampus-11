<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan peran 'admin' sudah ada di database
        // Jika belum, ini akan mengambil atau membuat peran 'admin'
        $adminRole = Role::firstOrCreate(['name' => 'admin'], [
            'description' => 'Administrator Sistem dengan akses penuh.'
        ]);

        // Buat user Admin pertama
        User::create([
            'name' => 'Faizin Ahmad',
            'email' => 'admin@stitusa.ac.id',
            'password' => Hash::make('password'), // Ganti dengan password yang lebih kuat di produksi!
            'email_verified_at' => now(),
            'role_id' => $adminRole->id, // Tetapkan role_id untuk admin
            'userable_type' => null, // Admin tidak terkait langsung dengan Mahasiswa/Dosen
            'userable_id' => null,   // Ini akan diisi ketika user dikaitkan dengan entitas spesifik
        ]);

        // Contoh membuat user Mahasiswa (tanpa detail Mahasiswa dulu)
        $mahasiswaRole = Role::firstOrCreate(['name' => 'mahasiswa'], [
            'description' => 'Pengguna mahasiswa.'
        ]);

        User::create([
            'name' => 'Mahasiswa Test',
            'email' => 'mahasiswa@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'role_id' => $mahasiswaRole->id,
            'userable_type' => null,
            'userable_id' => null,
        ]);

        // Contoh membuat user Dosen (tanpa detail Dosen dulu)
        $dosenRole = Role::firstOrCreate(['name' => 'dosen'], [
            'description' => 'Pengguna dosen/pengajar.'
        ]);

        User::create([
            'name' => 'Dosen Test',
            'email' => 'dosen@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'role_id' => $dosenRole->id,
            'userable_type' => null,
            'userable_id' => null,
        ]);

        // Anda bisa menambahkan user test lainnya jika diperlukan
    }
}
