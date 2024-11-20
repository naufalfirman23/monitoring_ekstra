<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('attendances', function (Blueprint $table) {
            // Menghapus foreign key constraint dari kolom extracurricular_id jika ada
            $table->dropForeign(['extracurricular_id']);
            
            // Hapus kolom extracurricular_id
            $table->dropColumn('extracurricular_id');

            // Tambah kolom id_session sebagai foreign key yang berelasi dengan tabel sessions
            $table->unsignedBigInteger('id_session')->after('id');
            $table->foreign('id_session')->references('id')->on('sessions')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attendances', function (Blueprint $table) {
            // Tambah kembali kolom extracurricular_id
            $table->unsignedBigInteger('extracurricular_id')->nullable();

            // Hapus kolom id_session beserta foreign key-nya
            $table->dropForeign(['id_session']);
            $table->dropColumn('id_session');
            
            // Tambah foreign key kembali pada extracurricular_id
            $table->foreign('extracurricular_id')->references('id')->on('extracurriculars')->onDelete('cascade')->onUpdate('cascade');
        });
    }
};
