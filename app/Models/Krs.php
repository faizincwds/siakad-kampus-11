<?php

namespace App\Models;

use App\Models\User;
use App\Models\Kelas;
use App\Models\Semester;
use App\Models\KrsDetail;
use App\Models\Mahasiswa;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Krs extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'krs';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'mahasiswa_id',
        'semester_id',
        'status',
        'tanggal_pengajuan',
        'tanggal_persetujuan',
        'disetujui_oleh',
        'catatan_persetujuan',
    ];

    protected $casts = [
        'tanggal_pengajuan' => 'datetime',
        'tanggal_persetujuan' => 'datetime',
    ];

    // Relasi ke Mahasiswa
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }

    // Relasi ke Semester
    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }

    // Relasi ke User (yang menyetujui)
    public function disetujuiOleh()
    {
        return $this->belongsTo(User::class, 'disetujui_oleh');
    }

    // Relasi ke detail KRS
    public function details()
    {
        return $this->hasMany(KrsDetail::class, 'krs_id');
    }

    // Relasi langsung ke kelas-kelas yang diambil dalam KRS ini
    public function kelas()
    {
        return $this->belongsToMany(Kelas::class, 'krs_details', 'krs_id', 'kelas_id');
    }
}
