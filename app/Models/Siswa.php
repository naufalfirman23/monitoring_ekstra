<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;
    protected $table = 'siswas';
    protected $fillable = [
        'nama',          
        'email',     
        'no_telepon',        
        'id_user',  
        'tanggal_lahir', 
        'nis', 
    ];

}
