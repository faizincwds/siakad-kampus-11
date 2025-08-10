<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Dosen;
use App\Models\ProgramStudi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DosenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan Anda memiliki data Program Studi di database
        $mpi = ProgramStudi::where('kode', 'MPI')->first();
        $pgmi = ProgramStudi::where('kode', 'PGMI')->first();

        // Data Dosen yang akan diisi
        $dataDosen = [
            [
                'nidn' => '0011038501',
                'nama_lengkap' => 'Prof. Dr. Ir. Ahmad Yani',
                'gelar_depan' => 'Prof. Dr. Ir.',
                'gelar_belakang' => 'M.T.',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '1975-03-11',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Kebon Jeruk No. 1',
                'nomor_telepon' => '081122334455',
                'email' => 'ahmad.yani@example.com',
                'program_studi_id' => $mpi->id ?? null,
                'user_email' => 'dosen@example.com', // Email user yang akan dikaitkan
            ],
            [
                'nidn' => '0022079002',
                'nama_lengkap' => 'Dr. Siti Rahayu',
                'gelar_depan' => 'Dr.',
                'gelar_belakang' => 'S.Kom., M.Kom.',
                'tempat_lahir' => 'Surabaya',
                'tanggal_lahir' => '1980-07-22',
                'jenis_kelamin' => 'P',
                'alamat' => 'Jl. Diponegoro No. 15',
                'nomor_telepon' => '081233445566',
                'email' => 'siti.rahayu@example.com',
                'program_studi_id' => $pgmi->id ?? null,
                'user_email' => null, // Contoh dosen tanpa akun user awal
            ],
            [
                'nidn' => '0033018203',
                'nama_lengkap' => 'Drs. Budiarjo',
                'gelar_depan' => 'Drs.',
                'gelar_belakang' => 'M.Si.',
                'tempat_lahir' => 'Semarang',
                'tanggal_lahir' => '1978-01-05',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Gajah Mada No. 30',
                'nomor_telepon' => '087788990011',
                'email' => 'budiarjo@example.com',
                'program_studi_id' => $mpi->id ?? null,
                'user_email' => null,
            ],
            // Tambahkan data dosen lain sesuai kebutuhan
        ];

        foreach ($dataDosen as $dosenData) {
            // Buat atau temukan data dosen
            $dosen = Dosen::firstOrCreate(
                ['nidn' => $dosenData['nidn']],
                [
                    'nama_lengkap' => $dosenData['nama_lengkap'],
                    'gelar_depan' => $dosenData['gelar_depan'],
                    'gelar_belakang' => $dosenData['gelar_belakang'],
                    'tempat_lahir' => $dosenData['tempat_lahir'],
                    'tanggal_lahir' => $dosenData['tanggal_lahir'],
                    'jenis_kelamin' => $dosenData['jenis_kelamin'],
                    'alamat' => $dosenData['alamat'],
                    'nomor_telepon' => $dosenData['nomor_telepon'],
                    'email' => $dosenData['email'],
                    'program_studi_id' => $dosenData['program_studi_id'],
                ]
            );

            // Jika ada user_email yang ditentukan, kaitkan dengan akun User yang sudah ada
            if ($dosenData['user_email']) {
                $user = User::where('email', $dosenData['user_email'])->first();

                if ($user) {
                    // Perbarui userable_type dan userable_id
                    $user->userable_id = $dosen->id;
                    $user->userable_type = Dosen::class;
                    $user->save();
                } else {
                    // Jika user belum ada, buat user baru dan kaitkan
                    // Anda bisa menyesuaikan password dan role_id sesuai kebutuhan
                    $dosenRole = Role::firstOrCreate(['name' => 'dosen']);
                    $newUser = User::create([
                        'name' => $dosenData['nama_lengkap'],
                        'email' => $dosenData['user_email'],
                        'password' => Hash::make('password'), // Password default
                        'email_verified_at' => now(),
                        'role_id' => $dosenRole->id,
                        'userable_id' => $dosen->id,
                        'userable_type' => Dosen::class,
                    ]);
                }
            }
        }
    }
}
