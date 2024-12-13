<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Discussion extends Model
{
    /** @use HasFactory<\Database\Factories\DiscussionFactory> */
    use HasFactory;

    protected $guarded = [
        'module_id',
        'title',
        'teacher_id'
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'teacher_id', 'id');
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
