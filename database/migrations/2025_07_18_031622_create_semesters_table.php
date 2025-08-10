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
        Schema::create('semesters', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Menggunakan UUID sebagai primary key
            $table->string('nama_semester')->unique(); // Contoh: Ganjil 2023/2024
            $table->string('tahun_akademik'); // Contoh: 2023/2024
            $table->enum('jenis_semester', ['Ganjil', 'Genap', 'Pendek']); // Ganjil, Genap, atau Pendek (jika ada)
            $table->boolean('is_active')->default(false); // Kolom untuk menandai semester aktif
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('semesters');
    }
};
