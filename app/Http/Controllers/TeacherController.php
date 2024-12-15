<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Module;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{
    public function index()
    {
        $teacher = Auth::user()->teacher;

        // Get today's day (e.g., 'Monday')
        $today = now()->format('l');

        // Get courses the teacher is teaching today
        $todaySchedules = $teacher->courses()
            ->with(['classrooms' => function ($query) use ($today) {
                $query->wherePivot('day', $today);
            }])
            ->get();

        // Get all courses taught by the teacher
        $allCourses = $teacher->courses;

        $recentCourseId = request()->cookie('recent_course_id' . Auth::id());
        $recentCourse = $recentCourseId ? Course::find($recentCourseId) : null;

        return view('teacher.dashboard', compact('teacher', 'todaySchedules', 'allCourses', 'recentCourse'));
    }

    public function showCourse($id)
    {
        cookie()->queue('recent_course_id' . Auth::id(), $id, 60 * 24); // Expires in 1 day
        $course = Course::with(['classrooms', 'modules.lessons'])->findOrFail($id);
        return view('teacher.courses.show', compact('course'));
    }


    public function storeModule(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $course->modules()->create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ]);

        return redirect()->route('teacher.courses.show', $id)->with('success', 'Module added successfully!');
    }

    public function storeLesson(Request $request, $moduleId)
    {
        $module = Module::findOrFail($moduleId);
    
        // Validate input data
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|file|mimes:pdf|max:2048', // Ensure it's a PDF file
            'visible' => 'required|boolean',
        ]);
    
        // Handle file upload
        $filePath = $request->file('content')->store('lessons', 'public');
        // Create the lesson with the file path
        $lesson = $module->lessons()->create([
            'title' => $request->input('title'),
            'content' => $filePath, // Save the file path in the database
            'visible' => $request->input('visible'),
        ]);
    
        // Automatically create a discussion for the lesson
        $lesson->discussion()->create([
            'teacher_id' => Auth::user()->teacher->id,
            'title' => "Discussion for {$lesson->title}",
            'description' => "Discuss the content of {$lesson->title} here.",
        ]);
    
        return redirect()->route('teacher.courses.show', $module->course->id)
            ->with('success', 'Lesson added successfully!');
    }

    public function leaderboard(){
        return view('teacher.courses.leaderboard');
    }
}
