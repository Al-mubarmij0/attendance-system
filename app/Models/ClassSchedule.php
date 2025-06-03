<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class ClassSchedule extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'lecturer_id',
        'course_id',
        'day',
        'start_time',
        'end_time',
        'venue',
        'notes',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function lecturer()
    {
        return $this->belongsTo(User::class, 'lecturer_id');
    }
}
