<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    /** @use HasFactory<\Database\Factories\StudentFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'nik',
        'profile_picture',
        'email',
        'password',
        'phone_number',
        'date_of_birth',
        'address',
        'enrollment_date',
        'admin_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function checks(): HasMany
    {
        return $this->hasMany(Answer::class, 'student_id', 'id');
    }

    public function quizResults(): HasMany
    {
        return $this->hasMany(QuizResult::class);
    }

    public function submits(): HasMany
    {
        return $this->hasMany(Submission::class, 'student_id', 'id');
    }

    public function classrooms()
    {
        return $this->belongsToMany(Classroom::class, 'classroom_student');
    }

    public function enrolled(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }

    public function reportCards()
    {
        return $this->hasMany(ReportCard::class);
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class, 'student_id', 'id');
    }
}
