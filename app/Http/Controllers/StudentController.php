<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Models\Comment;
use App\Models\Course;

class StudentController extends Controller
{
    public function index()
    {
        $student = Auth::user()->student;

        $dayOfWeek = now()->format('l');

        // Today's schedule
        $scheduleOfTheDay = $student->classrooms()
            ->with(['courses' => function ($query) use ($dayOfWeek) {
                $query->where('day', $dayOfWeek)
                    ->whereDate('end_date', '>=', now());
            }])
            ->get()
            ->pluck('courses')
            ->flatten();

        // Weekly schedule
        $weekSchedule = $student->classrooms()
            ->with(['courses' => function ($query) {
                $query->whereDate('end_date', '>=', now())
                    ->orderBy('day');
            }])
            ->get()
            ->pluck('courses')
            ->flatten();

        // All courses
        $allCourses = $student->classrooms()
            ->with('courses')
            ->get()
            ->pluck('courses')
            ->flatten();

        // Recent replies
        $recentReplies = Comment::with(['discussion', 'user'])
            ->whereHas('discussion', function ($query) use ($student) {
                $query->whereIn('module_id', $student->classrooms->pluck('id'));
            })
            ->whereHas('user', function ($query) {
                $query->where('role', 'teacher');
            })
            ->latest()
            ->limit(3)
            ->get();

        // dd($weekEvents->toArray());
        return view('student.dashboard', compact('student', 'scheduleOfTheDay', 'weekSchedule', 'allCourses', 'recentReplies'));
    }

    public function showCourse($courseId)
    {
        $student = Auth::user()->student;

        $course = Course::with(['modules.lessons', 'modules.quizzes', 'teacher'])
            ->whereHas('classrooms', function ($query) use ($student) {
                $query->whereIn('classrooms.id', $student->classrooms->pluck('id')); // Specify 'classrooms.id' explicitly
            })
            ->where('courses.id', $courseId) // Explicitly specify 'courses.id'
            ->firstOrFail();

        return view('student.courses.show', compact('course'));
    }
}
