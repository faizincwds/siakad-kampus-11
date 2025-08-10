<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KelasMahasiswa extends Model
{
    protected $table = 'kelas_mahasiswa'; // Nama tabel pivot
    public $incrementing = false; // Karena primary key gabungan
    protected $keyType = 'string'; // ID adalah UUID, tapi di pivot ini tidak ada ID tunggal

    protected $fillable = [
        'kelas_id',
        'mahasiswa_id',
        'nilai_akhir',
        'status_kelas',
    ];

    // Jika Anda ingin mendefinisikan relasi ke Kelas dan Mahasiswa dari pivot
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }
}
