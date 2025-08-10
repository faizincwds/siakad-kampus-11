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
        Schema::create('program_studi', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Primary Key UUID
            $table->string('nama', 255)->unique(); // Nama program studi (misal: 'Teknik Informatika'), harus unik
            $table->string('jenjang', 10); // Jenjang pendidikan (misal: 'D3', 'S1', 'S2', 'S3')
            $table->string('kode', 10)->unique()->nullable(); // Kode program studi (misal: 'TI'), opsional, unik

            // Foreign Key untuk fakultas_id, merujuk ke tabel 'fakultas'
            $table->foreignUuid('fakultas_id')
                  ->constrained('fakultas') // Mengacu ke tabel 'fakultas'
                  ->onDelete('cascade'); // Jika fakultas dihapus, program studi di dalamnya ikut terhapus

            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_studi');
    }
};
