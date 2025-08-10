<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mahasiswa', function (Blueprint $table) {
            // $table->id(); // Kolom ID sebagai primary key
            $table->uuid('id')->primary(); // Menggunakan UUID sebagai primary key
            $table->string('nim', 20)->unique(); // Nomor Induk Mahasiswa (NIM), harus unik
            $table->string('nama_lengkap', 255); // Nama lengkap mahasiswa
            $table->string('tempat_lahir', 100)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable(); // Laki-laki atau Perempuan
            $table->string('alamat', 255)->nullable();
            $table->string('nomor_telepon', 20)->nullable();
            $table->string('email', 255)->unique()->nullable(); // Email mahasiswa, bisa berbeda dengan email user

            // Foreign Key untuk program_studi_id, merujuk ke tabel 'program_studi'
            $table->foreignUuid('program_studi_id')
                  ->constrained('program_studi') // Mengacu ke tabel 'program_studi'
                  ->onDelete('restrict'); // Jika program studi dihapus, tidak boleh jika ada mahasiswa terkait
            $table->foreignUuid('dosen_wali_id')
                  ->nullable() // Dosen mungkin tidak langsung terikat ke satu prodi utama
                  ->constrained('dosen')
                  ->onDelete('set null'); // Jika prodi dihapus, set program_studi_id di dosen jadi NULL
            $table->string('status', 255)->nullable();
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswa');
    }
};
