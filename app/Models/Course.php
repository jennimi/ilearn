<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    /** @use HasFactory<\Database\Factories\CourseFactory> */
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'title',
        'description',
        'start_date',
        'end_date',
    ];

    protected static function booted()
    {
        static::created(function ($course) {
            $defaultModules = [
                ['title' => 'Module 1', 'description' => 'Introduction to the course.'],
                ['title' => 'Module 2', 'description' => 'Core topics and concepts.'],
                ['title' => 'Module 3', 'description' => 'Advanced topics and wrap-up.'],
            ];

            foreach ($defaultModules as $module) {
                Module::create([
                    'course_id' => $course->id,
                    'title' => $module['title'],
                    'description' => $module['description'],
                ]);
            }
        });
    }


    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'teacher_id', 'id');
    }

    public function classrooms(): BelongsToMany
    {
        return $this->belongsToMany(Classroom::class, 'classroom_courses')
            ->withPivot('day', 'start_time', 'end_time');
    }

    public function modules(): HasMany
    {
        return $this->hasMany(Module::class, 'course_id', 'id');
    }
}
