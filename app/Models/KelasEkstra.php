<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelasEkstra extends Model
{
    use HasFactory;
    protected $table = 'kelas_ekstra';
    protected $fillable = [
        'id_siswa',
        'id_guru',
        'id_ekstrakurikuler',
        'konfirmasi'
    ];
    public function ekstra()
    {
        return $this->belongsTo(Ekstrakurikuler::class, 'id_ekstrakurikuler');
    }

    // Relasi ke model Siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }

    // Relasi ke model Guru
    public function guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru');
    }

    // Relasi ke model Ekstrakurikuler
    public function ekstrakurikuler()
    {
        return $this->belongsTo(Ekstrakurikuler::class, 'id_ekstrakurikuler');
    }
}
