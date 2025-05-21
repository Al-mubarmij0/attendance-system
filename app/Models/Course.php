<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Import BelongsTo

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'department',
        'credits',
        'description',
        'lecturer_id' // This is correct and should be fillable
    ];

    /**
     * A Course belongs to one Lecturer.
     */
    public function lecturer(): BelongsTo // Add return type hint
    {
        // This should reference the Lecturer model, as lecturer_id in courses table
        // is the foreign key for the 'lecturers' table.
        return $this->belongsTo(Lecturer::class, 'lecturer_id');
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'course_student')
                    ->where('role', 'student')
                    ->withTimestamps();
    }

    public function attendanceRecords()
    {
        return $this->hasMany(Attendance::class);
    }
}