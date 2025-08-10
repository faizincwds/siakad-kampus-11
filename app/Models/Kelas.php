<?php

namespace App\Models;

use App\Models\Dosen;
use App\Models\Semester;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kelas extends Model
{
    use HasFactory;

    // Tentukan nama tabel karena tidak mengikuti konvensi plural Laravel
    protected $table = 'kelas'; // Nama tabel sesuai keinginan Anda
    protected $primaryKey = 'id';
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
        'nama_kelas',
        'mata_kuliah_id',
        'dosen_id',
        'room_id',
        'day_of_week', // Senin, Selasa, dst.
        'start_time',  // format 'HH:MM:SS'
        'end_time',    // format 'HH:MM:SS'
        'semester_id',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    /**
     * Dapatkan mata kuliah yang diajarkan di kelas ini.
     */
    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'mata_kuliah_id');
    }

    /**
     * Dapatkan dosen pengampu kelas ini.
     */
    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id');
    }

    /**
     * Dapatkan semua mahasiswa yang terdaftar di kelas ini.
     */
    public function mahasiswas()
    {
        // Relasi Many-to-Many dengan Mahasiswa melalui tabel pivot 'kelas_mahasiswa'
        return $this->belongsToMany(Mahasiswa::class, 'kelas_mahasiswa', 'kelas_id', 'mahasiswa_id')
                    ->withPivot('nilai_akhir', 'status_kelas') // Tambahkan kolom pivot jika diperlukan
                    ->withTimestamps(); // Jika tabel pivot punya created_at/updated_at
    }

    // Relasi ke Ruangan
    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    /**
     * Memeriksa bentrok jadwal untuk sebuah kelas.
     *
     * @param string $dayOfWeek Hari dalam seminggu (misal: 'Monday')
     * @param string $startTime Waktu mulai (misal: '08:00:00')
     * @param string $endTime Waktu selesai (misal: '09:30:00')
     * @param string $roomId ID Ruangan
     * @param string $dosenId ID Dosen
     * @param string $semesterId ID Semester
     * @param string|null $excludeKelasId ID Kelas yang sedang diupdate (untuk mengabaikan dirinya sendiri)
     * @return \Illuminate\Support\Collection Kelas-kelas yang bentrok
     */
    public static function checkConflicts(
        string $dayOfWeek,
        string $startTime,
        string $endTime,
        string $roomId,
        string $dosenId,
        string $semesterId,
        ?string $excludeKelasId = null
    ): Collection {
        $query = self::where('day_of_week', $dayOfWeek)
                    ->where('semester_id', $semesterId)
                    ->where(function ($q) use ($startTime, $endTime) {
                        // Cek bentrok waktu:
                        // (startA < endB) AND (endA > startB)
                        $q->where('start_time', '<', $endTime)
                          ->where('end_time', '>', $startTime);
                    });

        // Bentrok Ruangan ATAU Bentrok Dosen
        $query->where(function ($q) use ($roomId, $dosenId) {
            $q->where('room_id', $roomId) // Bentrok Ruangan
              ->orWhere('dosen_id', $dosenId); // Bentrok Dosen
        });

        // Abaikan kelas yang sedang diedit (jika ada)
        if ($excludeKelasId) {
            $query->where('id', '!=', $excludeKelasId);
        }

        return $query->get();
    }

    /**
     * Helper untuk mendapatkan nama hari yang lebih readable.
     * Bisa ditambahkan di model atau helper global
     */
    public function getDayNameAttribute()
    {
        $days = [
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu',
            'Sunday'    => 'Minggu',
        ];
        return $days[$this->day_of_week] ?? $this->day_of_week;
    }
}
