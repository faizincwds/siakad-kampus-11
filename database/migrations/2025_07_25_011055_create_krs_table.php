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
        Schema::create('krs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            // Gunakan foreignUuid() untuk kolom foreign key.
            // Ini secara otomatis akan membuat kolom dan menambahkan foreign key constraint.
            $table->foreignUuid('mahasiswa_id')->constrained('mahasiswa')->onDelete('cascade');
            $table->foreignUuid('semester_id')->constrained('semesters')->onDelete('cascade');
            // Untuk disetujui_oleh, jika bisa null, tambahkan nullable()
            $table->foreignUuid('disetujui_oleh')->nullable()->constrained('users')->onDelete('set null');
            $table->string('status')->default('pending'); // pending, approved, rejected
            $table->timestamp('tanggal_pengajuan')->useCurrent();
            $table->timestamp('tanggal_persetujuan')->nullable();
            $table->text('catatan_persetujuan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('krs');
    }
};
