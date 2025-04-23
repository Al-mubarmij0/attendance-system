<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassSchedule extends Model
{
    public function course()
{
    return $this->belongsTo(Course::class);
}

public function lecturer()
{
    return $this->belongsTo(User::class, 'lecturer_id');
}

}
