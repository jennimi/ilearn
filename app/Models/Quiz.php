<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Carbon\Carbon;

class Quiz extends Model
{
    /** @use HasFactory<\Database\Factories\QuizFactory> */
    use HasFactory;

    protected $fillable = [
        'module_id',
        'title',
        'description',
        'deadline',
        'duration'
    ];

    public function isDeadlinePassed()
    {
        return $this->deadline && Carbon::now()->greaterThan($this->deadline);
    }

    public function result(): HasOne
    {
        return $this->hasOne(QuizResult::class, 'quiz_id', 'id');
    }

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class, 'module_id', 'id');
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class, 'quiz_id', 'id');
    }

    public function quizResults()
    {
        return $this->hasMany(QuizResult::class, 'quiz_id', 'id');
    }
}
