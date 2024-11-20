<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    // Nama tabel (jika nama tabel tidak sesuai dengan konvensi Laravel)
    protected $table = 'attendances';

    // Kolom-kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'id_session',
        'user_id',
        'izin',
    ];

    // Jika Anda ingin menggunakan custom primary key
    // protected $primaryKey = 'id';

    // Jika tabel tidak menggunakan timestamps (created_at, updated_at)
    // public $timestamps = false;

    /**
     * Relasi ke model lain jika diperlukan
     */

    // Relasi ke tabel sessions
    public function session()
    {
        return $this->belongsTo(SessionsClass::class, 'id_session');
    }

    // Relasi ke tabel users
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
