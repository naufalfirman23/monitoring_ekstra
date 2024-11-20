<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ekstrakurikuler extends Model
{
    use HasFactory;

    protected $table = 'extracurriculars'; // Nama tabel di database

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',          
        'description',     
        'teacher_id',        
        'jadwal'  
    ];

    /**
     * Relationship with the user model for the pembimbing.
     */
    public function pembimbing()
    {
        return $this->belongsTo(Guru::class, 'teacher_id');
    }
    public function sessions()
    {
        return $this->hasMany(SessionsClass::class, 'extracurricular_id');
    }
}
