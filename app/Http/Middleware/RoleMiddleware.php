<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $roles): Response
    {
        // 1. Pastikan pengguna sudah login
        if (!Auth::check()) {
            // Jika belum login, arahkan ke halaman login
            return redirect()->route('login');
        }

        $user = Auth::user();

        // 2. Pastikan pengguna memiliki role
        // Jika user tidak punya role atau role-nya null, dia tidak akan bisa punya izin
        if (!$user || !$user->role) {
            return response()->view('errors.403', ['message' => 'Anda tidak memiliki peran yang ditetapkan.'], 403);
        }

        // 3. Ubah string peran menjadi array (jika dipisahkan koma)
        $roles = explode(',', $roles);

        if ($user->role && in_array($user->role->name, $roles)) {
            return $next($request);
        }

        // 4. Cek apakah peran pengguna ada di dalam daftar peran yang diizinkan
        if (in_array($user->role->name, $roles)) {
            return $next($request); // Peran diizinkan, lanjutkan request
        }

        // 5. Jika tidak ada kondisi yang terpenuhi, tolak akses dengan halaman 403
        return response()->view('errors.403', ['message' => 'Akses ditolak. Anda tidak memiliki izin untuk melihat halaman ini.'], 403);

    }
}
