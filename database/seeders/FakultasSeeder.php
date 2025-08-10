<?php

namespace Database\Seeders;

use App\Models\Fakultas;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FakultasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataFakultas = [
            [
                'nama' => 'STIT Tunas Bangsa Banjarnegara',
                'kode' => 'STITUSA',
            ],

            // Tambahkan fakultas lain jika diperlukan
        ];

        foreach ($dataFakultas as $fakultas) {
            Fakultas::firstOrCreate(['nama' => $fakultas['nama']], $fakultas);
        }
    }
}
