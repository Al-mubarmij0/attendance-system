<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; // Add this import

class Lecturer extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $fillable = [
        'user_id', // Foreign key to the users table
        'staff_id',
        'specialization',
        'bio',
    ];

    /**
     * A lecturer belongs to one user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * A lecturer can teach many courses.
     * This assumes 'courses.lecturer_id' points to 'lecturers.id'.
     */
    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    public function getFullNameAttribute()
    {
        return $this->user ? $this->user->name : 'Unknown';
    }

    public function hasSpecialization($specialization)
    {
        return $this->specialization === $specialization;
    }
}