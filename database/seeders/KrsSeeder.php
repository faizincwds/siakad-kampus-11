<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Krs;
use App\Models\Role;
use App\Models\User;
use App\Models\Semester;
use App\Models\Mahasiswa;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KrsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan ada data di tabel yang direferensikan
        $mahasiswas = Mahasiswa::all();
        $semesters = Semester::all();
        // Mengambil ID role dari tabel 'roles'
        $roleAdminId = Role::where('name', 'admin')->pluck('id')->first(); // Dapatkan ID untuk role 'admin'
        $roleDosenId = Role::where('name', 'dosen')->pluck('id')->first(); // Dapatkan ID untuk role 'dosen'

        // Pastikan role-role ini ada di database Anda
        if (!$roleAdminId || !$roleDosenId) {
            $this->command->error('Roles "admin" or "dosen" not found. Please run RoleSeeder first.');
            return;
        }

        // Ambil user yang memiliki role 'admin' atau 'dosen'
        $users = User::whereIn('role_id', [$roleAdminId, $roleDosenId])->get();

        if ($mahasiswas->isEmpty() || $semesters->isEmpty() || $users->isEmpty()) {
            $this->command->info('Tidak cukup data di tabel Mahasiswa, Semester, atau User untuk membuat KRS.');
            return;
        }

        // Hapus data lama jika ada
        // Krs::truncate();

        // Contoh KRS 1: Pending
        $mahasiswa1 = $mahasiswas->random();
        $semester1 = $semesters->random();
        Krs::create([
            'id' => Str::uuid(),
            'mahasiswa_id' => $mahasiswa1->id,
            'semester_id' => $semester1->id,
            'status' => 'pending',
            'tanggal_pengajuan' => Carbon::now()->subDays(5),
            'tanggal_persetujuan' => null,
            'disetujui_oleh' => null,
            'catatan_persetujuan' => null,
            'created_at' => Carbon::now()->subDays(5),
            'updated_at' => Carbon::now()->subDays(5),
        ]);

        // Contoh KRS 2: Approved
        $mahasiswa2 = $mahasiswas->except($mahasiswa1->id)->random(); // Pilih mahasiswa berbeda
        $semester2 = $semesters->except($semester1->id)->random(); // Pilih semester berbeda
        $approverUser = $users->random();
        Krs::create([
            'id' => Str::uuid(),
            'mahasiswa_id' => $mahasiswa2->id,
            'semester_id' => $semester2->id,
            'status' => 'approved',
            'tanggal_pengajuan' => Carbon::now()->subDays(10),
            'tanggal_persetujuan' => Carbon::now()->subDays(8),
            'disetujui_oleh' => $approverUser->id,
            'catatan_persetujuan' => 'KRS disetujui oleh ' . $approverUser->name,
            'created_at' => Carbon::now()->subDays(10),
            'updated_at' => Carbon::now()->subDays(8),
        ]);

        // Contoh KRS 3: Rejected
        $mahasiswa3 = $mahasiswas->except([$mahasiswa1->id, $mahasiswa2->id])->random();
        $semester3 = $semesters->except([$semester1->id, $semester2->id])->random();
        $rejecterUser = $users->random();
        Krs::create([
            'id' => Str::uuid(),
            'mahasiswa_id' => $mahasiswa3->id,
            'semester_id' => $semester3->id,
            'status' => 'rejected',
            'tanggal_pengajuan' => Carbon::now()->subDays(15),
            'tanggal_persetujuan' => Carbon::now()->subDays(13),
            'disetujui_oleh' => $rejecterUser->id,
            'catatan_persetujuan' => 'Ada konflik jadwal dengan mata kuliah lain.',
            'created_at' => Carbon::now()->subDays(15),
            'updated_at' => Carbon::now()->subDays(13),
        ]);

        $this->command->info('KRS seeded successfully.');
    }
}
