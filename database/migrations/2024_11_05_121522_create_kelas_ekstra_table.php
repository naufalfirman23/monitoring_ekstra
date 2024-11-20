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
        Schema::create('kelas_ekstra', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_siswa');
            $table->unsignedBigInteger('id_guru');
            $table->unsignedBigInteger('id_ekstrakurikuler');
            $table->timestamps();
            
            // Foreign key constraints with ON UPDATE and ON DELETE CASCADE
            $table->foreign('id_siswa')
                ->references('id')->on('siswas')
                ->onUpdate('cascade')
                ->onDelete('cascade');
                
            $table->foreign('id_guru')
                ->references('id')->on('gurus')
                ->onUpdate('cascade')
                ->onDelete('cascade');
                
            $table->foreign('id_ekstrakurikuler')
                ->references('id')->on('extracurriculars')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas_ekstra');
    }
};
