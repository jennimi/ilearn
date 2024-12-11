<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Classroom_Course extends Model
{
    /** @use HasFactory<\Database\Factories\ClassroomCourseFactory> */
    use HasFactory;

    protected $guarded = ['id', 'course_id', 'classroom_id', 'day', 'start_time', 'end_time'];

    public function classified(): BelongsTo
    {
        return $this->belongsTo(Classroom::class, 'classroom_id', 'id');
    }

    public function courses(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
}
