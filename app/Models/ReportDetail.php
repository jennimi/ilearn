<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportDetail extends Model
{
    use HasFactory;

    protected $fillable = ['report_card_id', 'course_id', 'grade'];

    public function reportCard()
    {
        return $this->belongsTo(ReportCard::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
