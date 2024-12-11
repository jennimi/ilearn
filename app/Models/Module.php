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
        'description',
    ];


    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class, 'module_id', 'id');
    }

    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class, 'module_id', 'id');
    }
}
