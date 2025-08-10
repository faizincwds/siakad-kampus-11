<?php

namespace App\Models;

use App\Models\Krs;
use App\Models\Kelas;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KrsDetail extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'krs_details';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'krs_id',
        'kelas_id',
    ];

    // Relasi ke KRS induk
    public function krs()
    {
        return $this->belongsTo(Krs::class, 'krs_id');
    }

    // Relasi ke Kelas
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }
}
