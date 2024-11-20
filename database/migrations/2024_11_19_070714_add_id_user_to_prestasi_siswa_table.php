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
        Schema::table('prestasi_siswa', function (Blueprint $table) {
            $table->unsignedBigInteger('id_user')->after('id'); // Tambahkan kolom id_user setelah kolom id
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade'); // Asumsikan tabel users sudah ada
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prestasi_siswa', function (Blueprint $table) {
            $table->dropForeign(['id_user']); // Hapus foreign key
            $table->dropColumn('id_user');   // Hapus kolom id_user
        });
    }
};
