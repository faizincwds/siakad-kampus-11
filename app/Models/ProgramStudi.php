<?php

namespace App\Models;

use App\Models\Fakultas;
use App\Models\Mahasiswa;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProgramStudi extends Model
{
    use HasFactory;

    // Tentukan nama tabel karena tidak mengikuti konvensi plural Laravel (ProgramStudi -> program_studis)
    protected $table = 'program_studi';
    public $incrementing = false; // Karena menggunakan UUID
    protected $keyType = 'string'; // Karena menggunakan UUID
    protected $primaryKey = 'id';  // Memberitahu Laravel nama kolom primary key

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string) Str::uuid();
        });
    }

    // Kolom yang dapat diisi secara massal
    protected $fillable = [
        'id',
        'nama',
        'jenjang',
        'kode',
        'fakultas_id',
    ];

    /**
     * Dapatkan fakultas yang memiliki program studi ini.
     */
    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class);
    }

    /**
     * Dapatkan semua mahasiswa yang terdaftar di program studi ini.
     */
    public function mahasiswas()
    {
        // Nanti akan mengacu ke model Mahasiswa
        return $this->hasMany(Mahasiswa::class);
    }


}
