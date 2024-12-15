<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Module extends Model
{
    /** @use HasFactory<\Database\Factories\ModuleFactory> */
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'description'
    ];

    // protected static function booted()
    // {
    //     static::created(function ($module) {
    //         $module->discussion()->create([
    //             'teacher_id' => $module->course->teacher_id,
    //             'title' => "Discussion for {$module->title}",
    //         ]);
    //     });
    // }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class, 'module_id', 'id');
    }

    public function discussion()
    {
        return $this->hasOne(Discussion::class);
    }

    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class, 'module_id', 'id');
    }

    // public function classrooms()
    // {
    //     return $this->hasManyThrough(
    //         Classroom::class, // Final model
    //         Course::class,    // Intermediate model
    //         'id',             // Foreign key on the courses table (module_id in modules table)
    //         'course_id',             // Foreign key on the classrooms table
    //         'id',      // Local key on the modules table
    //         'id'    // Local key on the courses table
    //     );
    // }
}
