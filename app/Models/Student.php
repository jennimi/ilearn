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
        'profile_picture',
        'email',
        'password',
        'phone_number',
        'date_of_birth',
        'address',
        'enrollment_date',
        'admin_id',
        'classroom_id',
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

    public function evaluate(): HasMany
    {
        return $this->hasMany(Quiz_Result::class, 'student_id', 'id');
    }

    public function submits(): HasMany
    {
        return $this->hasMany(Submission::class, 'student_id', 'id');
    }

    public function assigned(): BelongsTo
    {
        return $this->belongsTo(Classroom::class, 'classroom_id', 'id');
    }

    public function enrolled(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }
}
