<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttendanceRecords extends Model
{
    protected $table = 'attendance_records';
    
    public $timestamps = false;
    
    protected $fillable = [
        'student_id',
        'date',
        'status',
        'remarks'
    ];
    
    protected $casts = [
        'date' => 'datetime'
    ];
    
    /**
     * Get the student that owns the attendance record
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Students::class);
    }
}
