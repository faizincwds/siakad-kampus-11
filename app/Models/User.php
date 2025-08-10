<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Role;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    // Tambahkan properti ini
    protected $primaryKey = 'id';
    public $incrementing = false; // Memberitahu Eloquent bahwa ID tidak auto-increment
    protected $keyType = 'string'; // Memberitahu Eloquent bahwa ID bertipe string (UUID)
    protected static function booted()
    {
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string) Str::uuid();
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id', // Tambahkan role_id ke fillable
        'userable_type', // Tambahkan juga userable_type
        'userable_id',   // Tambahkan juga userable_id
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Dapatkan peran (role) yang terkait dengan pengguna.
     */ // Relasi Many-to-One ke Role
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    /**
     * Dapatkan model orang tua (mahasiswa, dosen, admin) dari pengguna.
     */
    public function userable()
    {
        return $this->morphTo();
    }

    /**
     * Helper untuk memeriksa apakah pengguna memiliki peran tertentu.
     * Contoh penggunaan: $user->hasRole('admin')
     */
    public function hasRole($roles)
    {
        if (!$this->role) {
            return false;
        }

        if (is_array($roles)) {
            return in_array($this->role->name, $roles);
        }

        return $this->role->name === $roles;
    }

    /**
     * Helper untuk memeriksa apakah pengguna memiliki salah satu dari peran yang diberikan.
     * Contoh penggunaan: $user->hasAnyRole(['admin', 'dosen'])
     */
    // public function hasAnyRole(array $roleNames)
    // {
    //     return $this->role && in_array($this->role->name, $roleNames);
    // }
    public function hasPermissionTo($permissionName)
    {
        // Admin selalu punya semua izin
        if ($this->hasRole('admin')) {
            return true;
        }

        // Pastikan user punya role dan role tersebut punya relasi permissions
        if (!$this->role || !$this->role->permissions) {
            return false;
        }

        // Cek izin melalui peran yang dimiliki user
        return $this->role->permissions->contains('name', $permissionName);
    }
}
