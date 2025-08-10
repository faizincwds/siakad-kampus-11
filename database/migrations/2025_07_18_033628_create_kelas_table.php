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

        Schema::create('kelas', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Primary Key UUID
            $table->string('nama_kelas', 50); // Nama rombongan kelas, e.g., "Basis Data - A"
            // $table->string('tahun_akademik', 9);
            // $table->enum('semester_akademik', ['Ganjil', 'Genap', 'Pendek']);
            $table->foreignUuid('semester_id')
                  ->constrained('semesters') // Akan merujuk ke tabel 'semesters'
                  ->onDelete('restrict'); // Jika semester dihapus, kelas yang terhubung tidak bisa dihapus

            // Foreign Keys
            $table->foreignUuid('mata_kuliah_id')
                  ->constrained('mata_kuliah')
                  ->onDelete('cascade');

            $table->foreignUuid('dosen_id')
                  ->constrained('dosen')
                  ->onDelete('restrict'); // Dosen tidak bisa dihapus jika masih mengajar kelas

            $table->foreignUuid('room_id') // Ruangan untuk kelas ini
                  ->constrained('rooms')
                  ->onDelete('cascade');

            // Jadwal Fisik
            $table->string('day_of_week'); // Hari, e.g., 'Monday'
            $table->time('start_time');
            $table->time('end_time');

            $table->timestamps();

            // Unique constraint untuk mencegah bentrok jadwal di ruang yang sama pada waktu yang sama
            // Sekarang mencakup semester_id sebagai ganti tahun_akademik dan semester_akademik
            $table->unique(
                ['room_id', 'day_of_week', 'start_time', 'end_time', 'semester_id'], 'unique_kelas_schedule' // Nama indeks kustom
            );

            // Jika Anda juga ingin nama_kelas unik per mata kuliah per tahun/semester, bisa tambahkan:
            // $table->unique(['mata_kuliah_id', 'nama_kelas', 'tahun_akademik', 'semester_akademik'], 'unique_kelas_rombel');
        });


        // Schema::create('kelas', function (Blueprint $table) {
        //     $table->uuid('id')->primary(); // Primary Key UUID
        //     $table->string('nama_kelas', 50);
        //     $table->string('tahun_akademik', 9);
        //     $table->enum('semester_akademik', ['Ganjil', 'Genap', 'Pendek']);

        //     $table->foreignUuid('mata_kuliah_id')
        //           ->constrained('mata_kuliah')
        //           ->onDelete('cascade');

        //     $table->foreignUuid('dosen_id')
        //           ->constrained('dosen')
        //           ->onDelete('restrict');

        //     $table->timestamps();

        //     // Perbaikan di sini: Menggunakan 'idx_kelas_unique'
        //     $table->unique(
        //         ['mata_kuliah_id', 'nama_kelas', 'tahun_akademik', 'semester_akademik'],
        //         'idx_kelas_unique' // Nama indeks kustom yang baru
        //     );
        // });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};
