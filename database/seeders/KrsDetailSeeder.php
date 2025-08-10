<?php

namespace Database\Seeders;

use App\Models\Krs;
use App\Models\Kelas;
use App\Models\KrsDetail;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KrsDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan ada data di tabel yang direferensikan
        $krss = Krs::all();
        $kelas = Kelas::all();

        if ($krss->isEmpty() || $kelas->isEmpty()) {
            $this->command->info('Tidak cukup data di tabel KRS atau Kelas untuk membuat KrsDetail.');
            return;
        }

        // Hapus data lama jika ada
        // KrsDetail::truncate();

        foreach ($krss as $krs) {
            // Ambil beberapa kelas acak untuk setiap KRS
            $numClasses = rand(1,2); // Ambil antara 2 sampai 5 kelas
            $selectedKelas = $kelas->random($numClasses);

            foreach ($selectedKelas as $kls) {
                // Pastikan kelas ini belum ditambahkan ke KRS yang sama
                $exists = KrsDetail::where('krs_id', $krs->id)
                                   ->where('kelas_id', $kls->id)
                                   ->exists();
                if (!$exists) {
                    KrsDetail::create([
                        'id' => Str::uuid(),
                        'krs_id' => $krs->id,
                        'kelas_id' => $kls->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        $this->command->info('KrsDetail seeded successfully.');
    }
}
