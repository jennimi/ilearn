<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Question;
use Illuminate\Support\Facades\Storage;

class QuestionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'question_text' => 'required|string',
            'question_type' => 'required|in:single_choice,multiple_choice,short_answer',
            'points' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('questions/images', 'public');
        }

        Question::create([
            'quiz_id' => $request->input('quiz_id'),
            'question_text' => $request->input('question_text'),
            'question_type' => $request->input('question_type'),
            'points' => $request->input('points'),
            'image' => $imagePath,
        ]);

        return redirect()->route('teacher.quizzes.show', $request->input('quiz_id'))
            ->with('success', 'Question added successfully!');
    }

    public function update(Request $request, $id)
    {
        // Find the question by ID
        $question = Question::findOrFail($id);

        // Validate the incoming request
        $validated = $request->validate([
            'question_text' => 'required|string|max:255',
            'points' => 'required|integer|min:1',
            'image' => 'nullable|image|max:2048', // Optional, ensure image file is valid
        ]);

        // Handle the image if provided
        if ($request->hasFile('image')) {
            if ($question->image) {
                // Delete the old image
                Storage::disk('public')->delete($question->image);
            }
            // Store the new image
            $validated['image'] = $request->file('image')->store('questions', 'public');
        }

        // Update the question
        $question->update([
            'question_text' => $validated['question_text'],
            'points' => $validated['points'],
            'image' => $validated['image'] ?? $question->image, // Keep the old image if no new image is uploaded
        ]);

        return redirect()->back()->with('success', 'Question updated successfully.');
    }


    public function destroy($id)
    {
        // Find the question by ID
        $question = Question::with('choices')->findOrFail($id);

        // Delete all associated choices
        $question->choices()->delete();

        // Delete the question itself
        $question->delete();

        return redirect()->back()->with('success', 'Question deleted successfully.');
    }
}
