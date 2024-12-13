<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Lesson;

use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function store(Request $request, $moduleId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|file|mimes:pdf|max:2048',
            'visible' => 'required|boolean',
        ]);

        $module = Module::findOrFail($moduleId);

        // Handle file upload
        $path = $request->file('content')->store('lessons', 'public');

        // Create the lesson
        Lesson::create([
            'title' => $request->input('title'),
            'content' => $path,
            'visible' => $request->input('visible'),
            'module_id' => $module->id,
        ]);

        return redirect()->route('teacher.courses.show', $module->course_id)->with('success', 'Lesson added successfully!');
    }
}
