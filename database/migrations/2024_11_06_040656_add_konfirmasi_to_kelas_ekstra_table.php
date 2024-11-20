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
            $table->enum('konfirmasi', ['0', '1'])->default('0')->after('id_ekstrakurikuler');
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
