<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengumumanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengumuman', function (Blueprint $table) {
            $table->id(); // Auto increment primary key
            $table->string('judul'); // Kolom untuk judul pengumuman
            $table->text('deskripsi'); // Kolom untuk deskripsi pengumuman
            $table->date('tanggal'); // Kolom untuk tanggal pengumuman
            $table->enum('status', ['aktif', 'non-aktif'])->default('aktif'); // Kolom status pengumuman
            $table->string('gambar')->nullable(); // Kolom gambar untuk menyimpan path gambar pengumuman
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengumuman'); // Menghapus tabel pengumuman jika rollback
    }
}
