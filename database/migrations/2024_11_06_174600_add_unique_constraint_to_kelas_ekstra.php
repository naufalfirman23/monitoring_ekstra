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
        Schema::table('kelas_ekstra', function (Blueprint $table) {
            // Menambahkan unique constraint untuk kombinasi id_siswa, is_guru, dan id_ekstrakurikuler
            $table->unique(['id_siswa', 'id_guru', 'id_ekstrakurikuler']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kelas_ekstra', function (Blueprint $table) {
            //
        });
    }
};
