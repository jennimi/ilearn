<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Smalot\PdfParser\Parser;
use App\Models\Module;
use Ramsey\Uuid\Type\Integer;

class GeminiController extends Controller
{
    private function quizFromPrompt(Request $request)
    {
        $response = null;
        $quiz = [];
        $fileName = null;  // Initialize fileName variable

        // Check if a file is uploaded
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            // Get the file
            $file = $request->file('file');

            // // Get the uploaded file name
            // $fileName = $file->getClientOriginalName();

            // Read the contents of the file (e.g., PDF)
            $fileContents = $this->parsePdfFile($file);

            // Truncate the contents to 40,000 characters
            $fileContents = $this->truncateText($fileContents, 40000);

            // Sanitize file contents to ensure valid UTF-8 encoding
            $fileContents = $this->sanitizeUtf8($fileContents);

            // Prepare the query (context + file contents)
            $preQuery =
                "Generate a single string containing 10 multiple-choice questions formatted as: Question1? | Question2? | Question3?. Derive the questions from the article, making them as educative as possible. Separate each question with a vertical bar (|). Do not include any additional comments, explanations, or array formatting in the output.";
            $fullQuery = $preQuery . "\n" . $fileContents;

            // Call the Gemini API with the sanitized content
            $response = $this->callGeminiApi($fullQuery);

            // Process the response into questions
            $questions = $this->splitResponse($response);
            $quiz = $this->makeQuestionsArray($fileContents, $questions);

            return $quiz;
        } else {
            return null;
        }

        // $array = [
        //     'prompt' => $response,
        //     'fileName' => $fileName,
        //     'question' => $quiz
        // ];

        // return $array;
    }


    // Parse PDF file and extract text
    private function parsePdfFile($file)
    {
        $pdfParser = new Parser();
        $pdfText = $pdfParser->parseFile($file->getPathname());
        return $pdfText->getText();
    }

    // Truncate text to the specified length (e.g., 30,000 characters)
    private function truncateText($text, $maxLength)
    {
        return mb_substr($text, 0, $maxLength);
    }

    // Ensure the text is valid UTF-8 by converting it
    private function sanitizeUtf8($text)
    {
        // Convert to UTF-8 if necessary
        return mb_convert_encoding($text, 'UTF-8', 'UTF-8');
    }

    private function callGeminiApi(string $query)
    {
        // $apiKey = env('GEMINI_API_KEY');
        $apiKey = env('GEMINI_API_KEY');
        $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-latest:generateContent';

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post("{$url}?key={$apiKey}", [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $query]
                    ]
                ]
            ]
        ]);

        // Check if the response was successful
        if ($response->successful()) {
            $data = $response->json();

            // Access the 'text' part of the response
            if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                return $data['candidates'][0]['content']['parts'][0]['text'];  // Return the text value
            }

            // If no text is found, return a default message
            return 'No response text available';
        }

        // If the API request fails, return error details
        return [
            'error' => true,
            'message' => $response->body(),
            'status' => $response->status(),
        ];
    }

    private function splitResponse($questions)
    {
        // dd($questions);

        // Split the questions into an array based on the question mark (?)
        $questionsArray = explode("|", $questions);

        // Optional: Trim extra spaces from each element
        $questionsArray = array_map('trim', $questionsArray);

        // Remove any empty elements
        $questionsArray = array_filter($questionsArray);

        // Reindex the array
        $questionsArray = array_values($questionsArray);

        return $questionsArray;
    }

    private function makeChoices(string $query, string $question)
    {
        $makeAnswer =
            "Based on the given context, generate a single string multiple-choice question with exactly 4 distinct answer options, ensuring only one correct answer, which must always appear as the first option. Each choice must be unique, concise, and clear, avoiding redundancy or ambiguity. Choices should not be preceded by letters or numbers. Separate the choices with a vertical bar (|). Do not include any additional comments, repeated meanings, limit each answer to less than 255 characters, or explanations in the output, or array formatting in the output.";

        $fullQuery = $query . "\n" . $question . "\n" . $makeAnswer;
        $answers = $this->callGeminiApi($fullQuery);

        $choices = $this->splitResponse($answers);

        return $choices;
    }

    private function makeQuestionsArray($query, $questions)
    {
        $questionArray = [];

        foreach ($questions as $question) {
            // Here, you would add logic to dynamically determine the answers and options
            // For demonstration purposes, we will just hardcode answers and options
            $choices = $this->makeChoices($query, $question);
            $choices_shuffled = $choices; // Copy the original array

            for ($i = 0; $i < 27; $i++) {
                shuffle($choices_shuffled); // Shuffle the copy
            }

            $questionArray[] = [
                'question' => $question,
                'answer' => $choices[0],
                'options' => $choices_shuffled
            ];
        }

        return $questionArray;
    }

    public function generateQuiz(Request $request, $id)
    {
        $module = Module::findOrFail($id);

        $request->validate([
            'file' => 'required|mimes:pdf',
            'quizTitle' => 'required|string|max:255',
        ]);

        $quizData = $this->quizFromPrompt($request);

        // $preQuery = "Based on the given context above, generate exactly 10 multiple-choice questions. Each question should have at least 4 unique choices, with only one correct answer. Ensure that:
        // 1. The correct answer is clearly indicated.
        // 2. Choices do not repeat or mean the same thing.
        // 3. The questions are diverse and relevant to the given context.

        // Format the output as valid Json code, structured as follows:

        // \$quiz = [
        //     [
        //         'question' => 'Question text here',
        //         'answer' => 'Correct choice text here',
        //         'options' => ['Correct choice', 'Choice 2', 'Choice 3', 'Choice 4'],
        //     ],
        //     // Add more questions here...
        // ];

        // Do not include any comments, explanations, or additional text. Only return the Json code.";

        $processedQuestions = $this->processQuizData($quizData);
        $quiz = $this->createQuiz($request, $id, $processedQuestions);
        // return view('teacher.quizzes.generated', [
        //     'module' => $module,
        //     'courseName' => $module->course->title,
        //     'moduleName' => $module->title,
        //     'preFilledQuiz' => [
        //         'title' => $request->input('quizTitle'),
        //         'description' => 'Generated with AI',
        //         'questions' => $processedQuestions,
        //     ],
        // ]);

        return view('teacher.quizzes.edit', compact('quiz'));
    }

    public function createQuiz(Request $request, $id, $processedQuestions)
    {
        $module = Module::findOrFail($id);

        $quiz = $module->quizzes()->create([
            'title' => $request->input('quizTitle'),
            'description' => "AI Generated Quiz",
            'duration' => null,
            'deadline' => null,
        ]);

        foreach ($processedQuestions as $questionData) {
            $choices = $questionData['choices'] ?? [];
            $correctAnswers = array_keys(array_filter($choices, fn($choice) => $choice['is_correct'] ?? false));
            $questionPoints = $questionData['points'] ?? 1;
            $questionType = $questionData['question_type'] ?? "0";

            if (empty($questionType)) {
                $questionType = '0';
            }

            $question = $quiz->questions()->create([
                'question_text' => $questionData['question_text'],
                'question_type' => $questionType,
                'points' => $questionPoints,
                'image' => null, // No images in the data
            ]);

            foreach ($choices as $index => $choiceData) {
                $question->choices()->create([
                    'choice_text' => $choiceData['choice_text'],
                    'is_correct' => in_array($index, $correctAnswers),
                ]);
            }
        }
        return $quiz;
    }

    private function processQuizData(array $quizData)
    {
        $questions = [];

        foreach ($quizData as $item) {
            $question = [
                'question_text' => $item['question'],
                'points' => 1,
                'question_type' => '',
                'choices' => [],
            ];

            foreach ($item['options'] as $choice) {
                $question['choices'][] = [
                    'choice_text' => $choice,
                    'is_correct' => $choice === $item['answer'],
                ];
            }

            $questions[] = $question;
        }

        return $questions;
    }
}
