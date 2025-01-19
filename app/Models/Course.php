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
        'image'
    ];

    protected static function booted()
    {
        static::created(function ($course) {
            $defaultModules = [
                ['title' => 'Modul 1', 'description' => 'Pengenalan terhadap kursus.'],
                ['title' => 'Modul 2', 'description' => 'Topik dan konsep inti.'],
                ['title' => 'Modul 3', 'description' => 'Topik lanjutan dan penutup.'],
            ];

            foreach ($defaultModules as $module) {
                $newModule = Module::create([
                    'course_id' => $course->id,
                    'title' => $module['title'],
                    'description' => $module['description'],
                ]);

                Discussion::create([
                    'module_id' => $newModule->id,
                    'title' => "Discussion for {$module['title']}",
                    // 'description' => "This is the discussion forum for {$module['title']}. Feel free to ask questions and engage in discussions.",
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
