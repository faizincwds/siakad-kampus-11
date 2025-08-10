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
        Schema::create('kurikulum_mata_kuliah', function (Blueprint $table) {
            // Foreign Key untuk kurikulum_id, merujuk ke tabel 'kurikulum'
            $table->foreignUuid('kurikulum_id')
                  ->constrained('kurikulum') // Mengacu ke tabel 'kurikulum'
                  ->onDelete('cascade'); // Jika kurikulum dihapus, relasi di pivot ikut terhapus

            // Foreign Key untuk mata_kuliah_id, merujuk ke tabel 'mata_kuliah'
            $table->foreignUuid('mata_kuliah_id')
                  ->constrained('mata_kuliah') // Mengacu ke tabel 'mata_kuliah'
                  ->onDelete('cascade'); // Jika mata kuliah dihapus, relasi di pivot ikut terhapus

            // Kolom-kolom tambahan untuk informasi di pivot table
            $table->string('semester_ditawarkan', 10)->nullable(); // Semester di mana MK ini ditawarkan dalam kurikulum (misal: '1', '2', 'Ganjil', 'Genap')
            $table->enum('status_mk', ['Wajib', 'Pilihan', 'Peminatan'])->default('Wajib'); // Status Mata Kuliah dalam kurikulum

            // Menentukan primary key gabungan untuk mencegah duplikasi entri
            $table->primary(['kurikulum_id', 'mata_kuliah_id']);

            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kurikulum_mata_kuliah');
    }
};
