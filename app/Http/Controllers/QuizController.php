<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Module;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Answer;

class QuizController extends Controller
{
    public function storeQuiz(Request $request, $moduleId)
    {
        $module = Module::findOrFail($moduleId);

        // Validate the input
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

        // Handle questions if provided
        if ($request->has('questions')) {
            $questions = json_decode($request->input('questions'), true);

            foreach ($questions as $questionData) {
                $choices = $questionData['options'] ?? [];
                $answerText = $questionData['answer'] ?? null; // Get the correct answer text
                $imagePath = null;

                // Handle image if provided
                if (!empty($questionData['question_image'])) {
                    $imageFile = base64_decode($questionData['question_image']);
                    $imageName = 'question_' . uniqid() . '.png';
                    $imagePath = 'question_images/' . $imageName;

                    Storage::disk('public')->put($imagePath, $imageFile);
                }

                // Create the question
                $question = $quiz->questions()->create([
                    'question_text' => $questionData['question'],
                    'question_type' => 1, // Assume 1 = multiple-choice; adjust if needed
                    'points' => $questionData['points'] ?? 1,
                    'image' => $imagePath,
                ]);

                // Create choices and identify the correct answer
                foreach ($choices as $choiceText) {
                    $question->choices()->create([
                        'choice_text' => $choiceText,
                        'is_correct' => $choiceText === $answerText,
                    ]);
                }
            }
        }

        return redirect()
            ->route('teacher.quizzes.show', $quiz->id)
            ->with('success', 'Quiz created successfully!');
    }


    public function showQuiz($id)
    {
        $quiz = Quiz::with(['questions.choices'])->findOrFail($id);

        return view('teacher.quizzes.show', compact('quiz'));
    }


    public function createQuiz($moduleId)
    {
        $module = Module::findOrFail($moduleId);

        return view('teacher.quizzes.create', compact('module'));
    }

    public function takeQuiz($quizId)
    {
        $quiz = Quiz::with(['questions.choices'])->findOrFail($quizId);
        return view('student.quizzes.take', compact('quiz'));
    }

    public function submitQuiz(Request $request, $quizId)
    {
        $quiz = Quiz::with('questions.choices')->findOrFail($quizId);
        $student = Auth::user()->student;

        $request->validate([
            'answers' => 'required|array',
        ]);

        $totalscore = 0;
        $score = 0;

        foreach ($quiz->questions as $question) {
            $submittedAnswer = $request->input("answers.{$question->id}");
            $isCorrect = false;

            if ($question->question_type == '') { // Single Choice
                $choice = $question->choices->where('id', $submittedAnswer)->first();
                $isCorrect = $choice && $choice->is_correct;
                if ($isCorrect) {
                    $score += $question->points;
                }
                $totalscore += $question->points;

                Answer::create([
                    'question_id' => $question->id,
                    'student_id' => $student->id,
                    'answer_key' => $choice->id,
                    'answer_text' => $choice->choice_text,
                    'is_correct' => $isCorrect ? '1' : '0',
                ]);
            } elseif ($question->question_type == 'single_choice') { // Multiple Choice
                $correctChoices = $question->choices->where('is_correct', true)->pluck('id')->toArray();
                $submittedChoices = $submittedAnswer ?? [];

                $incorrectSelected = array_diff($submittedChoices, $correctChoices); // Selected but incorrect
                $correctMissed = array_diff($correctChoices, $submittedChoices); // Correct but not selected

                $penalty = count($incorrectSelected) + count($correctMissed);

                $questionScore = max(0, $question->points - $penalty);

                $score += $questionScore;
                $totalscore += $question->points;

                foreach ($submittedChoices as $choiceId) {
                    $choice = $question->choices->where('id', $choiceId)->first();

                    Answer::create([
                        'question_id' => $question->id,
                        'student_id' => $student->id,
                        'answer_key' => $choice->id,
                        'answer_text' => $choice->choice_text,
                        'is_correct' => in_array($choice->id, $correctChoices) ? '1' : '0',
                    ]);
                }
            } elseif ($question->question_type == 'multiple_choice') { // Short Answer
                $correctAnswerChoice = $question->choices->firstWhere('is_correct', true); // Get the correct answer choice
                $isCorrect = $correctAnswerChoice && strtolower(trim($submittedAnswer)) === strtolower(trim($correctAnswerChoice->choice_text));
                if ($isCorrect) {
                    $score += $question->points;
                }
                $totalscore += $question->points;

                Answer::create([
                    'question_id' => $question->id,
                    'student_id' => $student->id,
                    'answer_key' => $correctAnswerChoice ? $correctAnswerChoice->id : 1, // Use the ID of the correct choice
                    'answer_text' => $submittedAnswer,
                    'is_correct' => $isCorrect ? '1' : '0',
                ]);
            }
        }

        $student->quizResults()->create([
            'quiz_id' => $quiz->id,
            'score' => $totalscore > 0 ? ($score / $totalscore) * 100 : 0,
            'submission_date' => now(),
        ]);

        return redirect()->route('student.quizzes.review', $quiz->id)->with('success', 'Quiz submitted successfully! Your score is ' . $score);
    }


    public function reviewQuiz($quizId)
    {
        $quiz = Quiz::with(['questions.choices', 'questions.answers' => function ($query) {
            $query->where('student_id', Auth::user()->student->id);
        }])->findOrFail($quizId);

        return view('student.quizzes.review', compact('quiz'));
    }
}
