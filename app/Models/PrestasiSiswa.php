<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrestasiSiswa extends Model
{
    use HasFactory;
    protected $table = 'prestasi_siswa';

    protected $fillable = [
        'id_user',
        'nama_perlombaan',
        'tanggal_perlombaan',
        'juara_dicapai',
        'bidang_ekstrakurikuler',
        'file_sertifikat',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

}
