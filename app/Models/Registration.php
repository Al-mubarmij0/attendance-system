<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',    // Assuming user ID for the student
        'course_id',  // Assuming there's a course
        'status',     // e.g., 'pending', 'approved'
    ];

    // Optionally, define relationships if needed
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
