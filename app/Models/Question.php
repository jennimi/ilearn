<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Question extends Model
{
    /** @use HasFactory<\Database\Factories\QuestionFactory> */
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'question_text',
        'question_type',
        'points',
        'image',
    ];

    public function getTypeLabel()
    {
        $labels = [
            '' => 'Single Choice',
            'single_choice' => 'Multiple Choice',
            'multiple_choice' => 'Short Answer',
        ];

        return $labels[$this->question_type] ?? 'Unknown';
    }

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class, 'question_id', 'id');
    }

    public function lessons(): BelongsTo
    {
        return $this->belongsTo(Quiz::class, 'quiz_id', 'id');
    }

    public function choices()
    {
        return $this->hasMany(QuestionChoice::class);
    }
}
