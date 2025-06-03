<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
// Removed BelongsToMany because enrolledCourses moves to Student model

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
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
     * A User (student) has one Student profile.
     */
    public function student(): HasOne
    {
        return $this->hasOne(Student::class);
    }

    // REMOVE THIS RELATIONSHIP FROM User MODEL
    // public function enrolledCourses(): BelongsToMany
    // {
    //     return $this->belongsToMany(Course::class, 'course_user', 'user_id', 'course_id')->withTimestamps();
    // }

    /**
     * A User (lecturer) has one Lecturer profile.
     */
    public function lecturer(): HasOne
    {
        return $this->hasOne(Lecturer::class);
    }

    /**
     * A User (lecturer) can be assigned many courses.
     * This means `courses.lecturer_id` refers to `users.id` directly.
     */
    public function assignedCourses(): HasMany
    {
        return $this->hasMany(Course::class, 'lecturer_id');
    }

    /**
     * Get the class schedules for this User if they are a lecturer.
     * THIS REMAINS CORRECTLY ON THE User MODEL.
     */
    public function classSchedules(): HasMany
    {
        return $this->hasMany(ClassSchedule::class, 'lecturer_id'); // 'lecturer_id' in class_schedules points to 'users.id'
    }

    // Your other methods
    public function attendanceReports(): HasMany
    {
        return $this->hasMany(AttendanceReport::class, 'user_id');
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isLecturer()
    {
        return $this->role === 'lecturer';
    }

    public function isStudent()
    {
        return $this->role === 'student';
    }
}