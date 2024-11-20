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
        Schema::create('prestasi_siswa', function (Blueprint $table) {
            $table->id();
            $table->string('nama_perlombaan');
            $table->date('tanggal_perlombaan');
            $table->string('juara_dicapai');
            $table->string('bidang_ekstrakurikuler');
            $table->string('file_sertifikat')->nullable(); // Menyimpan path file sertifikat
            $table->timestamps(); // Untuk mencatat waktu create & update
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestasi_siswa');
    }
};
