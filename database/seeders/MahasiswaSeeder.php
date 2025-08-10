<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\ProgramStudi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan Anda memiliki data Program Studi di database
        $mpi = ProgramStudi::where('kode', 'MPI')->first();
        $pgmi = ProgramStudi::where('kode', 'PGMI')->first();

        // Data Mahasiswa yang akan diisi
        $dataMahasiswa = [
            [
                'nim' => '2023001',
                'nama_lengkap' => 'Budi Santoso',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '2005-01-15',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Merdeka No. 10',
                'nomor_telepon' => '081234567890',
                'email' => 'budi.santoso@example.com',
                'program_studi_id' => $mpi->id ?? null,
                'user_email' => 'mahasiswa@example.com', // Email user yang akan dikaitkan
                'status' => 'Lulus',
            ],
            [
                'nim' => '2023002',
                'nama_lengkap' => 'Siti Aminah',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '2004-05-20',
                'jenis_kelamin' => 'P',
                'alamat' => 'Jl. Sudirman No. 25',
                'nomor_telepon' => '081298765432',
                'email' => 'siti.aminah@example.com',
                'program_studi_id' => $pgmi->id ?? null,
                'user_email' => null, // Contoh mahasiswa tanpa akun user awal
                'status' => 'Lulus',
            ],
            [
                'nim' => '2023003',
                'nama_lengkap' => 'Joko Susilo',
                'tempat_lahir' => 'Surabaya',
                'tanggal_lahir' => '2005-03-10',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Pahlawan No. 5',
                'nomor_telepon' => '087654321098',
                'email' => 'joko.susilo@example.com',
                'program_studi_id' => $mpi->id ?? null,
                'user_email' => null,
                'status' => 'Aktif',
            ],
            // Tambahkan data mahasiswa lain sesuai kebutuhan
        ];

        foreach ($dataMahasiswa as $mahasiswaData) {
            // Buat atau temukan data mahasiswa
            $mahasiswa = Mahasiswa::firstOrCreate(
                ['nim' => $mahasiswaData['nim']],
                [
                    'nama_lengkap' => $mahasiswaData['nama_lengkap'],
                    'tempat_lahir' => $mahasiswaData['tempat_lahir'],
                    'tanggal_lahir' => $mahasiswaData['tanggal_lahir'],
                    'jenis_kelamin' => $mahasiswaData['jenis_kelamin'],
                    'alamat' => $mahasiswaData['alamat'],
                    'nomor_telepon' => $mahasiswaData['nomor_telepon'],
                    'email' => $mahasiswaData['email'],
                    'program_studi_id' => $mahasiswaData['program_studi_id'],
                ]
            );

            // Jika ada user_email yang ditentukan, kaitkan dengan akun User yang sudah ada
            if ($mahasiswaData['user_email']) {
                $user = User::where('email', $mahasiswaData['user_email'])->first();

                if ($user) {
                    // Perbarui userable_type dan userable_id
                    $user->userable_id = $mahasiswa->id;
                    $user->userable_type = Mahasiswa::class;
                    $user->save();
                } else {
                    // Jika user belum ada, buat user baru dan kaitkan
                    // Anda bisa menyesuaikan password dan role_id sesuai kebutuhan
                    $mahasiswaRole = Role::firstOrCreate(['name' => 'mahasiswa']);
                    $newUser = User::create([
                        'name' => $mahasiswaData['nama_lengkap'],
                        'email' => $mahasiswaData['user_email'],
                        'password' => Hash::make('password'), // Password default
                        'email_verified_at' => now(),
                        'role_id' => $mahasiswaRole->id, // role_id harus sesuai dengan tipe ID di tabel roles
                        'userable_id' => $mahasiswa->id, // ID mahasiswa tetap integer auto-increment untuk saat ini
                        'userable_type' => Mahasiswa::class,
                    ]);
                }
            }
        }
    }
}
