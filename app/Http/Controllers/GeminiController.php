<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GeminiController extends Controller
{
    public function askGemini(Request $request)
    {
        $response = null;
        $query = null;
        $quiz = [];

        // Check if there's a query in the request
        if ($request->isMethod('post')) {
            $preQuery = "Make me an array of 10 multiple choice questions, where the format is \"Question1? | Question2? | Question3?\" like it were a multiple choice quiz from this article, separate with a |, do not comment on it at all:\n";
            // $preQuery = "";
            $query = $request->input('query');
            $fullQuery = $preQuery."\n".$query;
            // Call Gemini API with the provided query
            $response = $this->callGeminiApi($fullQuery);

            $questions = $this->splitResponse($response);

            $quiz = $this->makeQuestionsArray($query, $questions);
        }

        // Return the view with the response (for both GET and POST)
        return view('gemini', compact('query',   'response', 'quiz'));
    }

    private function callGeminiApi(string $query)
    {
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
        $makeAnswer = "based on the given context above, give me multiple choice answers, just put the right answer in the front. Give me only 4 choices, 1 choice can have multiple answers, make only one correct, no more, no less, no additional comments, no repeating choices that mean the same, make sure the correct answer is the first choice to come out, separate each choice with a |";

        $fullQuery = $query . "\n" . $question . "\n" . $makeAnswer;
        $answers = $this->callGeminiApi($fullQuery);

        $choices = $this->splitResponse($answers);

        return $choices;
    }

    private function makeQuestionsArray($query, $questions){
        $questionArray = [];

        foreach ($questions as $question) {
            // Here, you would add logic to dynamically determine the answers and options
            // For demonstration purposes, we will just hardcode answers and options
            $choices = $this->makeChoices($query, $question);

            // $answer = "Sample answer for '$question'"; // Replace with actual logic
            // $options = ["Option 1", "Option 2", "Option 3"]; // Replace with actual options

            $questionArray[] = [
                'question' => $question,
                'answer' => $choices[0],
                'options' => $choices
            ];
        }

        return $questionArray;
    }
}
