<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Question;

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
}
