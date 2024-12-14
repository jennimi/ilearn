<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Answer extends Model
{
    /** @use HasFactory<\Database\Factories\AnswerFactory> */
    use HasFactory;

    protected $fillable = ['question_id', 'student_id', 'answer_key', 'answer_text', 'is_correct'];

    public function answered(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    public function questioned(): BelongsTo
    {
        return $this->belongsTo(Quiz::class, 'quiz_id', 'id');
    }
}
