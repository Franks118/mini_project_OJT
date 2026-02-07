<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
    protected $table = 'students';
    
    protected $fillable = [
        'student_number',
        'full_name',
        'course',
        'year_level',
        'status',
        'time_in',
        'time_out',
        'section',
        'teacher'
    ];
    
    protected $casts = [
        'status' => 'string',
        'year_level' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'time_in' => 'datetime',
        'time_out' => 'datetime'
    ];
}
