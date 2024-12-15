<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Submission;

class SubmissionController extends Controller
{
    public function show($id)
    {
        $submission = Submission::with('student', 'assignment')->findOrFail($id);
        return view('teacher.submissions.show', compact('submission'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'grade' => 'required|numeric|min:0',
        ]);

        $submission = Submission::findOrFail($id);
        $submission->update([
            'grade' => $request->input('grade'),
        ]);

        return redirect()->back()->with('success', 'Grade updated successfully!');
    }
}
