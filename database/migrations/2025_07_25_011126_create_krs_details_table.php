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
        Schema::create('krs_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('krs_id')->references('id')->on('krs')->onDelete('cascade');
            $table->foreignUuid('kelas_id')->references('id')->on('kelas')->onDelete('cascade');
            $table->timestamps();
            $table->unique(['krs_id', 'kelas_id']); // Satu kelas hanya bisa dipilih sekali dalam satu KRS
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('krs_details');
    }
};
