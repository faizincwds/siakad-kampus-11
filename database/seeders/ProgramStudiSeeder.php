<?php

namespace Database\Seeders;

use App\Models\Fakultas;
use App\Models\ProgramStudi;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProgramStudiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan Anda memiliki data Fakultas di database
        // Ambil ID Fakultas yang sudah ada
        $stitusa = Fakultas::where('kode', 'STITUSA')->first();


        // Data Program Studi yang akan diisi
        $programStudiData = [
            [
                'nama' => 'Manajemen Pendidikan Islam',
                'jenjang' => 'S1',
                'kode' => 'MPI',
                'fakultas_id' => $stitusa->id ?? null, // Gunakan ID FILKOM jika ada
            ],
            [
                'nama' => 'Pendidikan Guru Madrasah Ibtidaiyah',
                'jenjang' => 'S1',
                'kode' => 'PGMI',
                'fakultas_id' => $stitusa->id ?? null,
            ],
            // Tambahkan program studi lain sesuai kebutuhan
        ];

        foreach ($programStudiData as $ps) {
            // Gunakan firstOrCreate untuk mencegah duplikasi
            ProgramStudi::firstOrCreate(['nama' => $ps['nama']], $ps);
        }
    }
}
