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
        Schema::create('role_has_permissions', function (Blueprint $table) {
            // Foreign Key untuk role_id, merujuk ke tabel 'roles'
            $table->foreignUuid('role_id')
                  ->constrained('roles') // Mengacu ke tabel 'roles'
                  ->onDelete('cascade'); // Jika role dihapus, relasi di pivot ikut terhapus

            // Foreign Key untuk permission_id, merujuk ke tabel 'permissions'
            $table->foreignUuid('permission_id')
                  ->constrained('permissions') // Mengacu ke tabel 'permissions'
                  ->onDelete('cascade'); // Jika permission dihapus, relasi di pivot ikut terhapus

            // Menentukan primary key gabungan untuk mencegah duplikasi
            $table->primary(['role_id', 'permission_id']);

            // Opsional: Jika Anda ingin mencatat kapan relasi ini dibuat/diubah
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_has_permissions');
    }
};
