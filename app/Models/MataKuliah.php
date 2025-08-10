<?php

namespace App\Models;

use App\Models\Kurikulum;
use Illuminate\Support\Str;
use App\Models\ProgramStudi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MataKuliah extends Model
{
    use HasFactory;

    // Tentukan nama tabel karena tidak mengikuti konvensi plural Laravel
    protected $table = 'mata_kuliah';
    public $incrementing = false;
    protected $keyType = 'string';

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string) Str::uuid();
        });
    }

    // Kolom yang dapat diisi secara massal
    protected $fillable = [
        'kode_mk',
        'nama_mk',
        'sks',
        'semester',
        'deskripsi',
        'jenis_mata_kuliah',
        'program_studi_id',
    ];

    /**
     * Dapatkan program studi yang memiliki mata kuliah ini.
     */
    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class);
    }

    /**
     * Dapatkan semua kelas (perkuliahan) yang menggunakan mata kuliah ini.
     */
    public function kelas()
    {
        // Nanti akan mengacu ke model Kelas
        return $this->hasMany(Kelas::class);
    }

    /**
     * Dapatkan semua kurikulum yang mengandung mata kuliah ini.
     */
    public function kurikulum()
    {
        return $this->belongsToMany(Kurikulum::class, 'kurikulum_mata_kuliah', 'mata_kuliah_id', 'kurikulum_id')
                    ->withPivot('semester_ditawarkan', 'status_mk')
                    ->withTimestamps();
    }
}
