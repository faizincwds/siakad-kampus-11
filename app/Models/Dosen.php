<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\ProgramStudi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dosen extends Model
{
    use HasFactory;

    // Tentukan nama tabel karena tidak mengikuti konvensi plural Laravel (Dosen -> dosens)
    protected $table = 'dosen';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'id';

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string) Str::uuid();
        });
    }
    // --- AKHIR BAGIAN BARU ---

    // Kolom yang dapat diisi secara massal
    protected $fillable = [
        'nidn',
        'nama_lengkap',
        'gelar_depan',
        'gelar_belakang',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'nomor_telepon',
        'email',
        'program_studi_id',
    ];

    /**
     * Dapatkan program studi yang menjadi prodi utama dosen ini.
     */
    public function programStudi()
    {
        // Laravel akan mencari program_studi_id di tabel dosen
        // dan mencocokkannya dengan id di tabel program_studi
        return $this->belongsTo(ProgramStudi::class, 'program_studi_id');
    }

    // Anda bisa menambahkan accessor untuk mendapatkan nama lengkap + gelar
    public function getNamaLengkapGelarAttribute()
    {
        $nama = $this->nama_lengkap;
        if ($this->gelar_depan) {
            $nama = $this->gelar_depan . ' ' . $nama;
        }
        if ($this->gelar_belakang) {
            $nama = $nama . ', ' . $this->gelar_belakang;
        }
        return $nama;
    }

    /**
     * Dapatkan user account yang terkait dengan dosen ini.
     */
    public function user()
    {
        // Pastikan User::class mengacu ke model User yang ID-nya sudah UUID
        return $this->morphOne(User::class, 'userable');
    }
}
