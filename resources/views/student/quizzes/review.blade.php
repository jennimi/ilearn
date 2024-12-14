@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-primary">{{ $quiz->title }} - Review</h1>

        {{-- Fetch the student's quiz result --}}
        @php
            $quizResult = $quiz->quizResults->firstWhere('student_id', Auth::user()->student->id) ?? null;
        @endphp

        {{-- Display score or fallback message --}}
        <p class="text-muted">
            Your Score: {{ $quizResult ? $quizResult->score . '%' : 'No score available' }}
        </p>

        {{-- Iterate through questions --}}
        @foreach ($quiz->questions as $question)
            <div class="mb-4">
                <h5>{{ $question->question_text }}</h5>

                {{-- Display question image if available --}}
                @if ($question->image)
                    <img src="{{ asset('storage/' . $question->image) }}" alt="Question Image" class="img-fluid mb-3">
                @endif

                {{-- Handle answers based on question type --}}
                @if (in_array($question->question_type, ['', 'single_choice', 'multiple_choice']))
                    @foreach ($question->choices as $choice)
                        <div>
                            <span>{{ $choice->choice_text }}</span>
                            {{-- Check if the student selected this choice --}}
                            @php
                                $selectedAnswer = $question->answers
                                    ->where('student_id', Auth::user()->student->id)
                                    ->where('answer_key', $choice->id)
                                    ->first();
                            @endphp
                            @if ($selectedAnswer)
                                <span class="badge bg-info">Your Answer</span>
                            @endif
                        </div>
                    @endforeach
                @elseif ($question->question_type == 'short_answer')
                    {{-- Handle short answer --}}
                    @php
                        $studentAnswer = $question->answers
                            ->where('student_id', Auth::user()->student->id)
                            ->first();
                    @endphp
                    <p>
                        <strong>Your Answer:</strong> {{ $studentAnswer->answer_text ?? 'Not Answered' }}
                    </p>
                @endif
            </div>
        @endforeach
    </div>
@endsection
