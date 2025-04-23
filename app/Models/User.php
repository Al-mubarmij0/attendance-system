<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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

    /**
     * Scope to filter by role.
     */
    public function scopeRole($query, $role)
    {
        return $query->where('role', $role);
    }

    /**
     * Get the courses assigned to the user (for lecturers and students).
     */
    public function courses()
    {
        if ($this->role === 'student') {
            return $this->belongsToMany(Course::class, 'course_user', 'user_id', 'course_id');
        }

        if ($this->role === 'lecturer') {
            return $this->belongsToMany(Course::class, 'course_user', 'user_id', 'course_id');
        }

        return null;
    }

    /**
     * Get the class schedules (for lecturers only).
     */
    public function schedules()
    {
        if ($this->role === 'lecturer') {
            return $this->hasMany(ClassSchedule::class, 'lecturer_id');
        }

        return null;
    }

    /**
     * Get the attendance reports (for lecturers only).
     */
    public function attendanceReports()
    {
        if ($this->role === 'lecturer') {
            return $this->hasMany(AttendanceReport::class, 'lecturer_id');
        }

        return null;
    }

    /**
     * Admin can manage everything, but doesn't have courses or schedules.
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Admin can manage users, courses, schedules, etc.
     * This method is just a basic check for the admin role.
     */
    public function isAdminActions()
    {
        if ($this->role === 'admin') {
            // Define any additional logic for the admin if necessary.
            return true;
        }

        return false;
    }

        public function lecturer()
    {
        return $this->hasOne(Lecturer::class);
    }

}
