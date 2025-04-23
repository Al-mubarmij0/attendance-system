<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecturer extends Model
{
    use HasFactory;

    // Indicates whether the model should maintain timestamps
    public $timestamps = true;

    // Mass assignable attributes
    protected $fillable = [
        'user_id',
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
     */
    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    /**
     * Accessor to retrieve the full name from the related user.
     * Usage: $lecturer->full_name
     */
    public function getFullNameAttribute()
    {
        return $this->user ? $this->user->name : 'Unknown';
    }

    /**
     * Check if the lecturer has a given specialization.
     */
    public function hasSpecialization($specialization)
    {
        return $this->specialization === $specialization;
    }
}
