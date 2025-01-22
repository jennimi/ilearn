<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\Assignment;

class AssignmentController extends Controller
{
    public function show($id)
    {
        $assignment = Assignment::with('module.course')->findOrFail($id);
        $student = Auth::user()->student;
        $submission = $assignment->submission()->where('student_id', $student->id)->first();

        return view('student.assignments.show', compact('assignment', 'submission'));
    }
    public function submit(Request $request, $id)
    {
        $assignment = Assignment::findOrFail($id);
        $student = Auth::user()->student;

        $request->validate([
            'submission_file' => 'required|file|mimes:pdf,doc,docx|max:5120', // Max 5MB
        ]);

        $filePath = $request->file('submission_file')->store('submissions', 'public');

        $assignment->submission()->create([
            'assignment_id' => $assignment->id,
            'student_id' => $student->id,
            'file_path' => $filePath,
            'submission_date' => now(),
            'grade' => 0,
            'feedback' => ''
        ]);

        return redirect()->route('student.courses.show', $assignment->module->course->id)
            ->with('success', 'Tugas berhasil dikumpulkan!');
    }

    public function toggleVisibility($id)
    {
        $assignment = Assignment::findOrFail($id);
        $assignment->update(['visible' => !$assignment->visible]);

        return redirect()->back()->with('success', 'Assignment visibility updated successfully.');
    }

    public function teacherShow($id)
    {
        // Retrieve the assignment and its associated submissions
        $assignment = Assignment::with(['submissions.student'])->findOrFail($id);

        // Fetch classrooms through the course of the module
        $classrooms = $assignment->module->course->classrooms()->with('students')->get();

        return view('teacher.assignments.show', compact('assignment', 'classrooms'));
    }


    public function edit($id)
    {
        $assignment = Assignment::findOrFail($id);
        return view('teacher.assignments.edit', compact('assignment'));
    }

    public function update(Request $request, $id)
    {
        $assignment = Assignment::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'required|date|after:today',
            'visible' => 'required|boolean',
        ]);

        $assignment->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'deadline' => $request->input('deadline'),
            'visible' => $request->input('visible'),
        ]);

        return redirect()->route('teacher.assignments.show', $assignment->id)
            ->with('success', 'Assignment updated successfully!');
    }

    public function store(Request $request, $moduleId)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'deadline' => 'required|date',
            'visible' => 'required|boolean',
        ]);

        $validated['module_id'] = $moduleId;

        Assignment::create($validated);

        return redirect()->back()->with('success', 'Assignment added successfully.');
    }

    public function destroy($id)
    {
        $assignment = Assignment::findOrFail($id);

        $assignment->submissions()->delete();

        $assignment->delete();

        return redirect()->back()->with('success', 'Assignment and all related submissions deleted successfully.');
    }
}
