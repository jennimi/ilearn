<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    /** @use HasFactory<\Database\Factories\CourseFactory> */
    use HasFactory;
    
    protected $guarded = ['id'];

    public function taught(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'teacher_id', 'id');
    }

    public function subjects(): HasMany
    {
        return $this->hasMany(Classroom_Course::class, 'course_id', 'id');
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class, 'course_id', 'id');
    }

    public function modules(): HasMany
    {
        return $this->hasMany(Module::class, 'course_id', 'id');
    }
}
