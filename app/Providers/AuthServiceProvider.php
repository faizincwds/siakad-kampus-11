<?php

namespace App\Providers;

use Exception;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // $this->registerPolicies();

        // Implicitly grant "super admin" role every permission
        // This is a common pattern: User with 'admin' role always has full access
        Gate::before(function (User $user, string $ability) {
            if ($user->hasRole('admin')) {
                return true;
            }
        });

        // Register all permissions from database
        try {
            if (Schema::hasTable('permissions')) { // Pastikan tabel ada sebelum mencoba mengambil data
                foreach (Permission::all() as $permission) {
                    Gate::define($permission->name, function (User $user) use ($permission) {
                        return $user->hasPermissionTo($permission->name);
                    });
                }
            }
        } catch (Exception $e) {
            // Ini untuk mencegah error saat pertama kali menjalankan migrate:fresh
            // Jika tabel permissions belum ada, Gate tidak akan didefinisikan
            // Anda bisa log error ini jika ingin
            // \Log::warning('Could not load permissions for Gate: ' . $e->getMessage());
        }
    }
}
