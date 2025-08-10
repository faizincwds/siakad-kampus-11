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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignUuid('role_id')
                  ->nullable() // Izinkan NULL jika role belum ditetapkan atau bisa kosong
                  ->constrained('roles') // Foreign key ke tabel 'roles'
                  ->onDelete('set null'); // Jika role dihapus, set role_id di users jadi NULL

            // Kolom untuk polymorphic relationship
            $table->uuid('userable_id')->nullable()->after('role_id');
            $table->string('userable_type')->nullable()->after('userable_id');
            $table->index(['userable_id', 'userable_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
        // Cek dan hapus kolom role_id jika ada
        if (Schema::hasColumn('users', 'role_id')) {
            $table->dropForeign(['role_id']);
            $table->dropColumn('role_id');
        }

        // Cek dan hapus kolom morph jika ada
        // Hapus indeks untuk polymorphic relationship
            if (Schema::hasColumn('users', 'userable_id') && Schema::hasColumn('users', 'userable_type')) {
                $table->dropIndex(['userable_id', 'userable_type']);
                $table->dropColumn(['userable_id', 'userable_type']);
            }
    });
    }
};
