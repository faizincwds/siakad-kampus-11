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
        Schema::create('roles', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Kolom ID sebagai primary key (UUID)
            $table->string('name', 50)->unique(); // Nama peran (misal: 'admin', 'mahasiswa', 'dosen'), harus unik
            $table->text('description')->nullable(); // Deskripsi peran, opsional
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
