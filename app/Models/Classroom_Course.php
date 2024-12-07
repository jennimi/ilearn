<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom_Course extends Model
{
    /** @use HasFactory<\Database\Factories\ClassroomCourseFactory> */
    use HasFactory;
    
    protected $guarded = ['id'];
}
