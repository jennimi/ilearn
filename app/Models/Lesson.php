<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lesson extends Model
{
    /** @use HasFactory<\Database\Factories\LessonFactory> */
    use HasFactory;
    
    protected $guarded = ['id'];

    public function discussion(): HasOne
    {
        return $this->hasOne(Discussion::class, 'lesson_id', 'id');
    }

    public function modules(): BelongsTo
    {
        return $this->belongsTo(Module::class, 'module_id', 'id');
    }
}
