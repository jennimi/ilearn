<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Classroom extends Model
{
    /** @use HasFactory<\Database\Factories\ClassroomFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'time_period',
        'teacher_id',
        'admin_id',
    ];

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'classroom_courses')
            ->withPivot('day', 'start_time', 'end_time')
            ->withTimestamps();
    }

    public function classes(): HasMany
    {
        return $this->hasMany(Classroom_Course::class, 'classroom_id', 'id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'classroom_student');
    }

    public function made(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }

    public function reportCards()
    {
        return $this->hasMany(ReportCard::class);
    }
}
