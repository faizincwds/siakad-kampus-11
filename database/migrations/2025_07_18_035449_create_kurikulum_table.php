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
        Schema::create('kurikulum', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Primary Key UUID
            $table->string('nama_kurikulum', 100); // Misal: 'Kurikulum 2020'
            $table->string('tahun_mulai', 4); // Tahun mulai berlaku kurikulum (misal: '2020')
            $table->string('tahun_selesai', 4)->nullable(); // Tahun berakhirnya kurikulum (opsional)
            $table->text('deskripsi')->nullable(); // Deskripsi atau catatan kurikulum

            // Foreign Key untuk program_studi_id
            $table->foreignUuid('program_studi_id')
                  ->constrained('program_studi')
                  ->onDelete('restrict'); // Kurikulum tidak bisa dihapus jika masih ada di prodi

            $table->boolean('is_aktif')->default(true); // Menandai apakah kurikulum ini aktif saat ini

            // Unique constraint: Satu program studi hanya punya satu kurikulum aktif per tahun mulai
            $table->unique(['program_studi_id', 'tahun_mulai']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kurikulum');
    }
};
