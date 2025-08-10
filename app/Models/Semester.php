<?php

namespace App\Models;

use App\Models\Kelas;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Semester extends Model
{
    use HasFactory, HasUuids; // Tambahkan HasUuids di sini

    protected $fillable = [
        'nama_semester',
        'tahun_akademik',
        'jenis_semester',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Jika Anda ingin tabel 'kelas' berelasi ke 'semesters'
    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'semester_id');
    }
}
