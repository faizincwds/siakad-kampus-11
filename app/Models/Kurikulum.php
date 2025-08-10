<?php

namespace App\Models;

use App\Models\MataKuliah;
use Illuminate\Support\Str;
use App\Models\ProgramStudi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kurikulum extends Model
{
    use HasFactory;

    // Tentukan nama tabel karena tidak mengikuti konvensi plural Laravel
    protected $table = 'kurikulum';
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
        'nama_kurikulum',
        'tahun_mulai',
        'tahun_selesai',
        'deskripsi',
        'program_studi_id',
        'is_aktif',
    ];



    /**
     * Dapatkan program studi yang memiliki kurikulum ini.
     */
    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class);
    }

    /**
     * Dapatkan semua mata kuliah yang termasuk dalam kurikulum ini.
     * Kita akan membuat tabel pivot 'kurikulum_mata_kuliah' untuk ini.
     */
    public function mataKuliah()
    {
        return $this->belongsToMany(MataKuliah::class, 'kurikulum_mata_kuliah', 'kurikulum_id', 'mata_kuliah_id')
                    ->withPivot('semester_ditawarkan', 'status_mk') // Contoh pivot: semester ditawarkan, wajib/pilihan
                    ->withTimestamps();
    }
}
