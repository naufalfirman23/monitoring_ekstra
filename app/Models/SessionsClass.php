<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionsClass extends Model
{
    use HasFactory;
    protected $table = 'sessions';
    protected $fillable = [
        'user_id',
        'extracurricular_id',
        'session_date',
        'start_time',
        'end_time',
    ];

    public function ekstra()
    {
        return $this->belongsTo(Ekstrakurikuler::class, 'extracurricular_id');
    }
}
