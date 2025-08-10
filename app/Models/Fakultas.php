<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Models\ProgramStudi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fakultas extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'fakultas';
    protected $primaryKey = 'id';

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string) Str::uuid();
        });
    }

    // Kolom yang dapat diisi secara massal
    protected $fillable = [
        'id', // Penting jika Anda ingin secara eksplisit mengizinkan pengisian ID
        'nama', // Sesuaikan dengan nama kolom di migrasi
        'kode', // Sesuaikan dengan nama kolom di migrasi
    ];

    /**
     * Dapatkan semua program studi yang dimiliki fakultas ini.
     */
    public function programStudis()
    {
        // Nanti akan mengacu ke model ProgramStudi
        return $this->hasMany(ProgramStudi::class);
    }
}
