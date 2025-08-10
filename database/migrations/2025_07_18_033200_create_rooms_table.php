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
        Schema::create('rooms', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Menggunakan UUID sebagai Primary Key
            $table->string('name')->unique(); // Nama ruang (contoh: Lab Komputer 1, Ruang Teori A)
            $table->string('code')->unique(); // Kode ruang (contoh: LK1, RTA)
            $table->integer('capacity')->nullable(); // Kapasitas ruang (opsional)
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
