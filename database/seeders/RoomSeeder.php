<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roomsData = [
            ['name' => 'Laboratorium Komputer 1', 'code' => 'LK1', 'capacity' => 40],
            ['name' => 'Ruang Teori A', 'code' => 'RTA', 'capacity' => 60],
            ['name' => 'Auditorium Utama', 'code' => 'AUD', 'capacity' => 200],
            ['name' => 'Ruang Kelas B1', 'code' => 'RKB1', 'capacity' => 30],
            ['name' => 'Ruang Kelas B2', 'code' => 'RKB2', 'capacity' => 30],
        ];

        foreach ($roomsData as $roomData) {
            Room::firstOrCreate(['code' => $roomData['code']], $roomData);
        }

        $this->command->info('Data Ruangan berhasil di-seed.');
    }
}
