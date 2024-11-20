<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    use HasFactory;

    // Nama tabel yang digunakan oleh model ini
    protected $table = 'pengumuman';

    // Kolom yang bisa diisi (mass assignable)
    protected $fillable = [
        'judul',
        'deskripsi',
        'tanggal',
        'status',
        'gambar',
    ];

    // Kolom yang tidak boleh diubah (untuk keamanan)
    protected $guarded = [];

    // Menentukan format tanggal yang digunakan oleh model ini
    protected $dates = ['tanggal'];

    /**
     * Menyimpan gambar pengumuman.
     * Misalnya untuk menyimpan gambar menggunakan penyimpanan file Laravel.
     */
    public function storeGambar($file)
    {
        // Tentukan nama file dan direktori penyimpanan
        $filename = time() . '.' . $file->getClientOriginalExtension();
        
        // Simpan gambar ke storage/app/public/pengumuman
        $file->storeAs('public/pengumuman', $filename);

        return 'storage/pengumuman/' . $filename;
    }
}
