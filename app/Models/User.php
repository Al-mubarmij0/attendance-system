<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne; // Add this import
use Illuminate\Database\Eloquent\Relations\BelongsToMany; // Add this import

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // e.g., 'lecturer', 'student', 'admin'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function scopeRole($query, $role)
    {
        return $query->where('role', $role);
    }

    /**
     * A User (student) can enroll in many courses.
     * This uses the 'course_student' pivot table.
     */
    public function courses(): BelongsToMany // Specify return type
    {
         // Assuming 'course_student' is the pivot table for students enrolling in courses
        return $this->belongsToMany(Course::class, 'course_student', 'user_id', 'course_id')
                    ->withTimestamps(); // If you want timestamps on the pivot table
    }

    /**
     * A User (lecturer) has one Lecturer profile.
     */
    public function lecturer(): HasOne // Specify return type
    {
        return $this->hasOne(Lecturer::class);
    }

    // Keep other methods like schedules, attendanceReports, isAdmin, isAdminActions if they apply
    // Just make sure they don't conflict with the `lecturer_id` on the Course model for lecturer assignments.
    // For example, if lecturer_id on ClassSchedule refers to user ID, not lecturer profile ID, that's fine.

    public function schedules()
    {
        if ($this->role === 'lecturer') {
            return $this->hasMany(ClassSchedule::class, 'lecturer_id'); // Assuming lecturer_id here refers to User ID
        }
        return null;
    }

    public function attendanceReports()
    {
        if ($this->role === 'lecturer') {
            return $this->hasMany(AttendanceReport::class, 'lecturer_id'); // Assuming lecturer_id here refers to User ID
        }
        return null;
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isAdminActions()
    {
        return $this->role === 'admin';
    }
}