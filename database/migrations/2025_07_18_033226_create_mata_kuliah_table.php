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
        Schema::create('mata_kuliah', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Primary Key UUID
            $table->string('kode_mk', 20)->unique(); // Kode Mata Kuliah (misal: 'TI101'), harus unik
            $table->string('nama_mk', 255); // Nama Mata Kuliah (misal: 'Pemrograman Dasar')
            $table->integer('sks'); // Jumlah Satuan Kredit Semester (SKS)
            $table->string('semester', 10)->nullable(); // Semester mata kuliah (misal: 'Ganjil', 'Genap', '1', '2')
            $table->string('jenis_mata_kuliah', 10)->nullable(); // Wajib/Pilihan,
            $table->text('deskripsi')->nullable(); // Deskripsi mata kuliah

            // Foreign Key untuk program_studi_id
            // Setiap mata kuliah diasumsikan milik satu atau lebih program studi.
            // Untuk model sederhana, kita bisa asumsikan mata kuliah utama milik satu prodi.
            // Jika mata kuliah bisa dipakai lintas prodi secara fleksibel, tabel pivot akan lebih tepat.
            $table->foreignUuid('program_studi_id')
                  ->nullable() // Mata kuliah umum mungkin tidak terikat ke satu prodi spesifik
                  ->constrained('program_studi')
                  ->onDelete('set null'); // Jika prodi dihapus, set ID prodi di mata_kuliah jadi NULL

            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mata_kuliah');
    }
};
