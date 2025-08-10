<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\KrsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\Admin\DosenController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\FakultasController;
use App\Http\Controllers\Admin\SemesterController;
use App\Http\Controllers\Admin\KurikulumController;
use App\Http\Controllers\Admin\MahasiswaController;
use App\Http\Controllers\Admin\MataKuliahController;
use App\Http\Controllers\Admin\ProgramStudiController;
use App\Http\Controllers\Admin\KelasMahasiswaController;

// GET /admin/program-studi (index)
// GET /admin/program-studi/create (create)
// POST /admin/program-studi (store)
// GET /admin/program-studi/{program_studi} (show)
// GET /admin/program-studi/{program_studi}/edit (edit)
// PUT/PATCH /admin/program-studi/{program_studi} (update)
// DELETE /admin/program-studi/{program_studi} (destroy)
// Untuk banyak role (pakai koma tanpa spasi)
// Route::middleware(['auth', 'role:admin,dosen'])->group(...);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = Auth::user();
    return redirect()->route(match ($user->role->name ?? '') {
        'admin' => 'admin.dashboard',
        'dosen' => 'dosen.dashboard',
        'mahasiswa' => 'mahasiswa.dashboard',
        'staff' => 'staff.dashboard',
        default => '/',
    });
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/admin', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/dosen', [DashboardController::class, 'index'])->name('dosen.dashboard');
});

// Group Route untuk Admin
Route::prefix('admin')
    ->middleware(['auth','role:admin'])
    ->name('admin.')
    ->group(function () {
        // DATA USER
        Route::resource('users', UserController::class);
        Route::resource('dosen', DosenController::class);
        Route::resource('mahasiswa', MahasiswaController::class);

        // MASTER DATA
        Route::resource('fakultas', FakultasController::class);
        Route::resource('kurikulum', KurikulumController::class);
        Route::resource('mata-kuliah', MataKuliahController::class);
        Route::resource('program-studi', ProgramStudiController::class);
        Route::resource('permissions', PermissionController::class);
        Route::get('permissions/manage', [PermissionController::class, 'manage'])->name('permissions.manage');
        Route::put('permissions/manage', [PermissionController::class, 'update_manage'])->name('permissions.manage.update');
        Route::resource('semesters', SemesterController::class);
        Route::post('semesters/{semester}/set-active', [SemesterController::class, 'setActive'])->name('semesters.set-active');

        // KELAS PERKULIAHAN
        Route::resource('rooms', RoomController::class);
        Route::resource('kelas', KelasController::class);
        Route::resource('kelas.mahasiswa', KelasMahasiswaController::class)->only(['index', 'store', 'destroy']);
        Route::put('kelas/{kela}/mahasiswa/{mahasiswa}/update-nilai', [KelasMahasiswaController::class, 'updateNilai'])->name('kelas.mahasiswa.updateNilai');
        Route::resource('krs', KrsController::class)->only(['index', 'create', 'store', 'show']);
        Route::post('/krs/{kr}/approve', [KrsController::class, 'approve'])->name('krs.approve');
        Route::post('/krs/{kr}/reject', [KrsController::class, 'reject'])->name('krs.reject');


        // Wildcard untuk handle route yang tidak cocok
        Route::any('{any}', function () {
            return redirect()->route('dashboard');
        })->where('any', '.*');
});

// Group Route untuk Admin
Route::prefix('dosen')
    ->middleware(['auth','role:dosen'])
    ->name('dosen.')
    ->group(function () {
        Route::resource('dosen', DosenController::class);

        // Wildcard untuk handle route yang tidak cocok
        Route::any('{any}', function () {
            return redirect()->route('dashboard');
        })->where('any', '.*');
});



Route::middleware(['auth'])
    ->group(function () {

        // Route::resource('permissions', PermissionController::class);
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
 });

require __DIR__.'/auth.php';
