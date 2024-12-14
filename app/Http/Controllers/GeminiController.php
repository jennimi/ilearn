<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Smalot\PdfParser\Parser;

class GeminiController extends Controller
{
    public function askGemini(Request $request)
    {
        $response = null;
        $query = null;
        $quiz = [];
        $fileName = null;  // Initialize fileName variable

        // Check if a file is uploaded
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            // Get the file
            $file = $request->file('file');

            // Get the uploaded file name
            $fileName = $file->getClientOriginalName();

            // Read the contents of the file (e.g., PDF)
            $fileContents = $this->parsePdfFile($file);

            // Truncate the contents to 30,000 characters
            $fileContents = $this->truncateText($fileContents, 30000);

            // Sanitize file contents to ensure valid UTF-8 encoding
            $fileContents = $this->sanitizeUtf8($fileContents);

            // Prepare the query (context + file contents)
            $preQuery = "Make me an array of 10 multiple choice questions, where the format is \"Question1? | Question2? | Question3?\" like it were a multiple choice quiz from this article, separate with a |, do not comment on it at all:\n";
            $fullQuery = $preQuery . "\n" . $fileContents;

            // Call the Gemini API with the sanitized content
            $response = $this->callGeminiApi($fullQuery);

            // Process the response into questions
            $questions = $this->splitResponse($response);
            $quiz = $this->makeQuestionsArray($fileContents, $questions);
        }

        // Return the view with the response and file name
        return view('gemini', compact('query', 'response', 'quiz', 'fileName'));
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
        $apiKey = 'AIzaSyCqx8FXlQWb1FA6HdFMg7e5xbdLhUQeBdM';
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

    private function makeQuestionsArray($query, $questions)
    {
        $questionArray = [];

        foreach ($questions as $question) {
            // Here, you would add logic to dynamically determine the answers and options
            // For demonstration purposes, we will just hardcode answers and options
            $choices = $this->makeChoices($query, $question);

            $questionArray[] = [
                'question' => $question,
                'answer' => $choices[0],
                'options' => $choices
            ];
        }

        return $questionArray;
    }
}
