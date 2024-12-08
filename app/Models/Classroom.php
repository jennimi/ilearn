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
    
    protected $guarded = ['id'];

    public function classes(): HasMany
    {
        return $this->hasMany(Classroom_Course::class, 'classroom_id', 'id');
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'classroom_id', 'id');
    }

    public function made(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }
}
