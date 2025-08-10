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
        Schema::create('kelas_mahasiswa', function (Blueprint $table) {
            // Foreign Key untuk kelas_id, merujuk ke tabel 'kelas'
            $table->foreignUuid('kelas_id')
                  ->constrained('kelas') // Mengacu ke tabel 'kelas'
                  ->onDelete('cascade'); // Jika kelas dihapus, relasi di pivot ikut terhapus

            // Foreign Key untuk mahasiswa_id, merujuk ke tabel 'mahasiswa'
            $table->foreignUuid('mahasiswa_id')
                  ->constrained('mahasiswa') // Mengacu ke tabel 'mahasiswa'
                  ->onDelete('cascade'); // Jika mahasiswa dihapus, relasi di pivot ikut terhapus

            // Foreign Key untuk semester_id, merujuk ke tabel 'semesters'
            // Ini penting untuk melacak kelas di semester mana mahasiswa mengambilnya.
            $table->foreignUuid('semester_id')
                  ->constrained('semesters') // Mengacu ke tabel 'semesters'
                  ->onDelete('cascade'); // Jika semester dihapus, data di pivot ikut terhapus (opsional: bisa set null jika ingin historis)

            // Kolom-kolom tambahan untuk informasi di pivot table
            $table->decimal('nilai_angka', 5, 2)->nullable(); // Contoh: 85.50
            $table->string('nilai_huruf', 2)->nullable(); // Contoh: 'A', 'B+', 'C-'
            $table->enum('status_kelas', ['Lulus', 'Tidak Lulus', 'Mengulang', 'Sedang Berlangsung'])->default('Sedang Berlangsung');

            // Menentukan primary key gabungan untuk mencegah duplikasi pendaftaran mahasiswa di kelas yang sama
            $table->primary(['kelas_id', 'mahasiswa_id', 'semester_id']);

            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas_mahasiswa');
    }
};
