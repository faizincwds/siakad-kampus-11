<?php

namespace App\Models;

use App\Models\Kelas;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;

    protected $table = 'rooms'; // Nama tabel yang dihubungkan
    protected $primaryKey = 'id';
    public $incrementing = false; // Primary key tidak auto-increment
    protected $keyType = 'string'; // Tipe data primary key adalah string (untuk UUID)

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string) Str::uuid();
        });
    }

    // Kolom-kolom yang bisa diisi secara massal
    protected $fillable = [
        'name',
        'code',
        'capacity',
    ];

    // Relasi: Sebuah ruangan bisa memiliki banyak kelas/jadwal
    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'room_id');
    }
}
