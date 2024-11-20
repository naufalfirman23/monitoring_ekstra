<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;
    protected $table = 'gurus';
    protected $fillable = [
        'nama',          
        'email',     
        'no_telepon',        
        'id_user'  
    ];
    public function extracurriculars()
    {
        return $this->hasMany(Ekstrakurikuler::class, 'teacher_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

}
