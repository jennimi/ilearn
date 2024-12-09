<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Teacher extends Model
{
    /** @use HasFactory<\Database\Factories\TeacherFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'profile_picture',
        'email',
        'password',
        'phone_number',
        'date_of_birth',
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

    public function teaches(): HasMany
    {
        return $this->hasMany(Course::class, 'teacher_id', 'id');
    }

    public function discuss(): HasMany
    {
        return $this->hasMany(Discussion::class, 'teacher_id', 'id');
    }

    public function delegated(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }

}
