<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Lesson;
use Illuminate\Support\Facades\Storage;

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

    public function update(Request $request, $id)
    {
        $lesson = Lesson::findOrFail($id);

        if ($request->hasFile('content')) {
            if ($lesson->content) {
                Storage::delete($lesson->content);
            }
            $validated['content'] = $request->file('content')->store('lessons');
        }

        $lesson->update([
            'title' => $request['title'],
            'visible' => $request['visible'],
            'content' => $validated['content'] ?? $lesson->content,
        ]);

        return redirect()->back()->with('success', 'Lesson updated successfully.');
    }


    public function destroy($id)
    {
        $lesson = Lesson::findOrFail($id);
        if ($lesson->content) {
            Storage::delete($lesson->content);
        }
        $lesson->delete();
        return redirect()->back()->with('success', 'Lesson deleted successfully.');
    }
}
