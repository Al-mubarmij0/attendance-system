<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'department',
        'credits',
        'description',
        'lecturer_id'
    ];

    public function lecturer(): BelongsTo
    {
        // This still assumes 'lecturer_id' in courses table refers to the 'id' in the 'lecturers' table.
        return $this->belongsTo(Lecturer::class, 'lecturer_id');
    }

    /**
     * The students (Student profiles) who are offering this course.
     * This assumes the pivot table `course_student` uses `student_id` from the Student model.
     */
    public function students(): BelongsToMany
    {
        // Pivot table: 'course_student'
        // Foreign key for this model (Course): 'course_id'
        // Foreign key for the related model (Student): 'student_id'
        return $this->belongsToMany(Student::class, 'course_student', 'course_id', 'student_id')
                    ->withTimestamps();
    }

    public function classSchedules(): HasMany
    {
        return $this->hasMany(ClassSchedule::class);
    }

    public function attendanceRecords(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }
}