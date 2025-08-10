<?php

namespace App\Http\Controllers\Auth;

use App\Models\Role;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // 1. Ambil ID role 'mahasiswa' atau role default lainnya
        // Pastikan Anda sudah menjalankan seeder RoleSeeder dan memiliki role 'mahasiswa'
        $defaultRole = Role::where('name', 'mahasiswa')->first();

        // Jika role 'mahasiswa' tidak ditemukan, mungkin Anda ingin melempar error
        // atau fallback ke role lain, atau buat role baru.
        if (!$defaultRole) {
            // Ini bisa terjadi jika seeder Role belum dijalankan atau nama rolenya salah
            // Anda bisa pilih untuk:
            // a) Lempar exception: throw new \Exception("Default role 'mahasiswa' not found.");
            // b) Buat role baru secara on-the-fly (jika memang defaultnya harus ada)
            // c) Atur role_id menjadi null dan tangani nanti.
            // Untuk saat ini, kita akan melempar error agar Anda tahu jika ada masalah.
            throw new \Exception("Default role 'mahasiswa' not found. Please run RoleSeeder.");
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $defaultRole->id, // Tetapkan role_id di sini
            // Untuk relasi polimorfik userable, kita akan mengaturnya nanti
            // atau jika registrasi ini hanya untuk mahasiswa, kita bisa kaitkan di sini.
            // Untuk registrasi umum, biarkan userable_type dan userable_id null dulu jika tidak langsung dikaitkan.
            // Pastikan kolom userable_type dan userable_id di tabel users nullable jika tidak selalu diisi.
            'userable_type' => null, // Atau sesuaikan jika Anda ingin langsung mengaitkan
            'userable_id' => null,   // Misalnya: Mahasiswa::class dan $mahasiswa->id
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
