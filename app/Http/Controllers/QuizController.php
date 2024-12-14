<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Module;
use App\Models\Quiz;

class QuizController extends Controller
{
    public function storeQuiz(Request $request, $moduleId)
    {
        $module = Module::findOrFail($moduleId);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'questions' => 'nullable|json',
        ]);

        // Create the quiz
        $quiz = $module->quizzes()->create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ]);

        if ($request->has('questions')) {
            $questions = json_decode($request->input('questions'), true);

            foreach ($questions as $questionData) {
                $choices = $questionData['choices'] ?? [];
                $correctAnswerIndex = $questionData['correct_answer'] ?? null;
                $imagePath = null;

                if (isset($questionData['question_image'])) {
                    $imageFile = base64_decode($questionData['question_image']);
                    $imageName = 'question_' . uniqid() . '.png';
                    $imagePath = 'question_images/' . $imageName;

                    Storage::disk('public')->put($imagePath, $imageFile);
                }

                $question = $quiz->questions()->create([
                    'question_text' => $questionData['question_text'],
                    'question_type' => $questionData['question_type'],
                    'points' => $questionData['points'] ?? 1,
                    'image' => $imagePath,
                ]);

                if (!empty($choices)) {
                    foreach ($choices as $index => $choiceText) {
                        $question->choices()->create([
                            'choice_text' => $choiceText,
                            'is_correct' => $questionData['question_type'] != 2 && $correctAnswerIndex == $index,
                        ]);
                    }
                }
            }
        }

        return redirect()->route('teacher.quizzes.show', $quiz->id)->with('success', 'Quiz created successfully!');
    }


    public function showQuiz($id)
    {
        $quiz = Quiz::with(['questions.choices'])->findOrFail($id);

        // return redirect()->route('teacher.quizzes.show', $quiz->id)->with('success', 'Quiz created successfully!');
        return view('teacher.quizzes.show', compact('quiz'));
    }


    public function createQuiz($moduleId)
    {
        $module = Module::findOrFail($moduleId);

        return view('teacher.quizzes.create', compact('module'));
    }
}
