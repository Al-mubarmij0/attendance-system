<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany; // Import BelongsToMany

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'index_number',
        'department',    
        'level',
        'barcode_path',
        'qrcode_path',    
    ];

    /**
     * A Student profile belongs to one User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * A Student can be enrolled in many Courses.
     * This uses the 'course_student' pivot table.
     */
    public function enrolledCourses(): BelongsToMany
    {
        // Pivot table: 'course_student'
        // Foreign key for this model (Student): 'student_id'
        // Foreign key for the related model (Course): 'course_id'
        return $this->belongsToMany(Course::class, 'course_student', 'student_id', 'course_id')
                    ->withTimestamps();
    }
}