<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    // Override properti Spatie untuk menggunakan tabel Anda
    protected $table = 'roles';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    /**
     * The "booted" method of the model.
     * Digunakan untuk menggenerate UUID secara otomatis sebelum model disimpan
     */
    protected static function booted()
    {
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string) Str::uuid();
        });
    }

    // Kolom yang dapat diisi secara massal
    protected $fillable = [
        'id',
        'name',
        'description',
    ];

    /**
     * Dapatkan semua pengguna yang memiliki peran ini.
     */
    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }

    /**
     * Dapatkan semua izin yang terkait dengan peran ini.
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_has_permissions','role_id', 'permission_id');
    }
}
