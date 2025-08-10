<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        // Pastikan permissions dan roles tidak duplicated jika seeder dijalankan berkali-kali

        // 1. Buat permissions
        // Pastikan 'rooms' ada di dalam array $modules
        $modules = ['fakultas', 'program studi', 'dosen', 'mahasiswa', 'mata kuliah', 'kelas', 'rooms'];
        $permissionsData = [];
        foreach ($modules as $module) {
            $title = Str::title($module);
            $permissionsData[] = ['name' => "view $module", 'description' => "View $title data"];
            $permissionsData[] = ['name' => "create $module", 'description' => "Create $title data"];
            $permissionsData[] = ['name' => "edit $module", 'description' => "Edit $title data"];
            $permissionsData[] = ['name' => "delete $module", 'description' => "Delete $title data"];
        }
        $permissionsData[] = ['name' => 'view dashboard admin', 'description' => 'View admin dashboard'];

        // 2. Simpan permissions tanpa duplikasi
        foreach ($permissionsData as $permData) {
            Permission::firstOrCreate(['name' => $permData['name']], $permData);
        }

        // 3. Buat roles
        $roleAdmin = Role::firstOrCreate(['name' => 'admin'], ['description' => 'Administrator with full access']);
        $roleDosen = Role::firstOrCreate(['name' => 'dosen'], ['description' => 'University Lecturer']);
        $roleMahasiswa = Role::firstOrCreate(['name' => 'mahasiswa'], ['description' => 'University Student']);

        // 4. Berikan semua permissions kepada Admin
        // Ini akan otomatis mencakup izin 'rooms' yang baru
        $roleAdmin->permissions()->sync(Permission::pluck('id'));

        // 5. Berikan permissions spesifik kepada Dosen
        $dosenPermissionNames = [
            'view dosen', 'edit dosen',
            'view mahasiswa',
            'view mata kuliah',
            'view kelas', // Dosen bisa melihat kelas/jadwal
            // Tambahkan izin lain yang relevan untuk dosen di sini
        ];
        $dosenPermissionIds = Permission::whereIn('name', $dosenPermissionNames)->pluck('id')->toArray();
        $roleDosen->permissions()->sync($dosenPermissionIds);

        // 6. Berikan permissions kepada Mahasiswa
        $mahasiswaPermissionNames = [
            'view mahasiswa',
            'view mata kuliah',
            'view kelas', // Mahasiswa bisa melihat kelas/jadwal
            // Tambahkan izin lain yang relevan untuk mahasiswa di sini
        ];
        $mahasiswaPermissionIds = Permission::whereIn('name', $mahasiswaPermissionNames)->pluck('id')->toArray();
        $roleMahasiswa->permissions()->sync($mahasiswaPermissionIds);

        // 7. Buat pengguna contoh dan berikan peran secara langsung
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Administrator', 'password' => bcrypt('password')]
        );
        $adminUser->update(['role_id' => $roleAdmin->id]);

        $dosenUser = User::firstOrCreate(
            ['email' => 'dosen@example.com'],
            ['name' => 'Dosen Pengajar', 'password' => bcrypt('password')]
        );
        $dosenUser->update(['role_id' => $roleDosen->id]);

        $mahasiswaUser = User::firstOrCreate(
            ['email' => 'mahasiswa@example.com'],
            ['name' => 'Mahasiswa Baru', 'password' => bcrypt('password')]
        );
        $mahasiswaUser->update(['role_id' => $roleMahasiswa->id]);

        // 8. Informasi ke terminal
        $this->command->info('Roles, permissions, dan contoh pengguna berhasil di-seed.');
    }



    // public function run(): void
    // {
    //     // Pastikan permissions dan roles tidak duplicated jika seeder dijalankan berkali-kali

    //     // Create permissions
    //     $modules = ['fakultas', 'program studi', 'dosen', 'mahasiswa', 'mata kuliah', 'kelas', 'rooms'];
    //     $permissionsData = [];
    //     foreach ($modules as $module) {
    //         $title = Str::title($module);
    //         $permissionsData[] = ['name' => "view $module", 'description' => "View $title data"];
    //         $permissionsData[] = ['name' => "create $module", 'description' => "Create $title data"];
    //         $permissionsData[] = ['name' => "edit $module", 'description' => "Edit $title data"];
    //         $permissionsData[] = ['name' => "delete $module", 'description' => "Delete $title data"];
    //     }
    //     $permissionsData[] = ['name' => 'view dashboard admin', 'description' => 'View admin dashboard'];

    //     // 2. Simpan permissions tanpa duplikasi
    //     foreach ($permissionsData as $permData) {
    //         Permission::firstOrCreate(['name' => $permData['name']], $permData);
    //     }

    //     // Create roles
    //     $roleAdmin = Role::firstOrCreate(['name' => 'admin'], ['description' => 'Administrator with full access']);
    //     $roleDosen = Role::firstOrCreate(['name' => 'dosen'], ['description' => 'University Lecturer']);
    //     $roleMahasiswa = Role::firstOrCreate(['name' => 'mahasiswa'], ['description' => 'University Student']);

    //     // Assign all permissions to Admin
    //     // $allPermissions = Permission::pluck('id');
    //     // $roleAdmin->permissions()->sync($allPermissions);

    //     // 4. Assign all permissions to admin
    //     $roleAdmin->permissions()->sync(Permission::pluck('id'));

    //     // 5. Assign specific permissions ke dosen
    //     $dosenPermissionNames = [
    //         'view dosen', 'edit dosen',
    //         'view mahasiswa',
    //         'view mata kuliah', // diperbaiki dari 'view matakuliah'
    //     ];
    //     $dosenPermissionIds = Permission::whereIn('name', $dosenPermissionNames)->pluck('id')->toArray();
    //     $roleDosen->permissions()->sync($dosenPermissionIds);

    //     // 6. Assign permissions ke mahasiswa
    //     $mahasiswaPermissionNames = [
    //         'view mahasiswa',
    //         'view mata kuliah', // diperbaiki dari 'view matakuliah'
    //     ];
    //     $mahasiswaPermissionIds = Permission::whereIn('name', $mahasiswaPermissionNames)->pluck('id')->toArray();
    //     $roleMahasiswa->permissions()->sync($mahasiswaPermissionIds);


    //     // Create users and assign roles by directly setting role_id
    //     $adminUser = User::firstOrCreate(
    //         ['email' => 'admin@example.com'],
    //         ['name' => 'Administrator', 'password' => bcrypt('password')]
    //     );

    //     $adminUser->update(['role_id' => $roleAdmin->id]);

    //     $dosenUser = User::firstOrCreate(
    //         ['email' => 'dosen@example.com'],
    //         ['name' => 'Dosen Pengajar', 'password' => bcrypt('password')]
    //     );
    //     $dosenUser->update(['role_id' => $roleDosen->id]);

    //     $mahasiswaUser = User::firstOrCreate(
    //         ['email' => 'mahasiswa@example.com'],
    //         ['name' => 'Mahasiswa Baru', 'password' => bcrypt('password')]
    //     );
    //     $mahasiswaUser->update(['role_id' => $roleMahasiswa->id]);

    //     // Info ke terminal
    //     $this->command->info('Roles, permissions, and sample users seeded successfully.');
    // }
}
