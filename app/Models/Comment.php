<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    /** @use HasFactory<\Database\Factories\CommentFactory> */
    use HasFactory;
    
    protected $guarded = ['id'];

    public function commentable()
    {
        return $this->morphTo();
    }

    public function discussed(): BelongsTo
    {
        return $this->belongsTo(Discussion::class, 'discussion_id', 'id');
    }
}
