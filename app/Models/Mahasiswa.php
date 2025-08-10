<?php

namespace App\Models;

use App\Models\User;
use App\Models\Kelas;
use Illuminate\Support\Str;
use App\Models\ProgramStudi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mahasiswa extends Model
{
    use HasFactory;

    // Tentukan nama tabel karena tidak mengikuti konvensi plural Laravel (Mahasiswa -> mahasiswas)
    protected $table = 'mahasiswa';
    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string) Str::uuid();
        });
    }

    // Kolom yang dapat diisi secara massal
    protected $fillable = [
        'nim',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'nomor_telepon',
        'email',
        'program_studi_id',
        'tahun_masuk',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date', // Mengubah tanggal_lahir menjadi objek Carbon
    ];

    /**
     * Dapatkan program studi yang dimiliki mahasiswa ini.
     */
    public function programStudi()
    {
        // Laravel akan mencari program_studi_id di tabel mahasiswa
        // dan mencocokkannya dengan id di tabel program_studi
        return $this->belongsTo(ProgramStudi::class, 'program_studi_id');
    }

    /**
     * Dapatkan user account yang terkait dengan mahasiswa ini.
     */
    public function user()
    {
        // Pastikan User::class mengacu ke model User yang ID-nya sudah UUID
        return $this->morphOne(User::class, 'userable');
    }

    // Relasi: Mahasiswa memiliki satu Dosen Wali
    public function dosenWali()
    {
        return $this->belongsTo(Dosen::class, 'dosen_wali_id');
    }

    // Relasi One-to-Many: Mahasiswa memiliki banyak KRS
    public function krs()
    {
        return $this->hasMany(Krs::class, 'mahasiswa_id');
    }

    /**
     * Dapatkan semua kelas (perkuliahan) yang diambil mahasiswa ini.
     */
    public function kelas()
    {
        // Relasi Many-to-Many dengan Kelas melalui tabel pivot 'kelas_mahasiswa'
        return $this->belongsToMany(Kelas::class, 'kelas_mahasiswa', 'mahasiswa_id', 'kelas_id')
                    ->withPivot('nilai_angka', 'status_kelas', 'semester_id')// Tambahkan kolom pivot jika diperlukan
                    // ->withPivot('nilai_angka', 'nilai_huruf', 'status_kelulusan', 'semester_id')
                    ->withTimestamps(); // Jika tabel pivot punya created_at/updated_at
    }
}
