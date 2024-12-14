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

        return view('student.assignments.show', compact('assignment'));
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
            'student_id' => $student->id,
            'file_path' => $filePath,
            'submitted_at' => now(),
        ]);

        return redirect()->route('student.courses.show', $assignment->module->course->id)
            ->with('success', 'Assignment submitted successfully!');
    }
}
