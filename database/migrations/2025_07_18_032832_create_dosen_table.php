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
        Schema::create('dosen', function (Blueprint $table) {
            // $table->id(); // Kolom ID sebagai primary key
            $table->uuid('id')->primary(); // Menggunakan UUID sebagai primary key
            $table->string('nidn', 20)->unique(); // Nomor Induk Dosen Nasional (NIDN), harus unik
            $table->string('nama_lengkap', 255); // Nama lengkap dosen
            $table->string('gelar_depan', 50)->nullable(); // Gelar akademik di depan nama (misal: Dr.)
            $table->string('gelar_belakang', 50)->nullable(); // Gelar akademik di belakang nama (misal: S.Kom., M.T.)
            $table->string('tempat_lahir', 100)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->string('alamat', 255)->nullable();
            $table->string('nomor_telepon', 20)->nullable();
            $table->string('email', 255)->unique()->nullable(); // Email dosen, bisa berbeda dengan email user

            // Foreign Key untuk program_studi_id (opsional, jika dosen terikat pada satu prodi utama)
            // Jika seorang dosen bisa mengajar di banyak prodi, ini bisa menjadi tabel pivot terpisah.
            // Untuk sekarang, kita asumsikan dosen terkait dengan satu prodi utama.
            $table->foreignUuid('program_studi_id')
                  ->nullable() // Dosen mungkin tidak langsung terikat ke satu prodi utama
                  ->constrained('program_studi')
                  ->onDelete('set null'); // Jika prodi dihapus, set program_studi_id di dosen jadi NULL

            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dosen');
    }
};
