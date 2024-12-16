@extends('layouts.app')

@section('content')
    <div class="container">
        <div>
            <a href="{{ route('student.courses.show', $quiz->module->course->id) }}" class="btn btn-warning me-2"><i
                    class="bi bi-arrow-left tw-me-2 tw-fs-4 tw-group-hover:tw-text-blue-500"></i>
                <span class="tw-group-hover:tw-underline">Back</span></a>
        </div>
        <h1 class="text-primary">{{ $quiz->title }} - Review</h1>

        {{-- Fetch the student's quiz result --}}
        @php
            $quizResult = $quiz->quizResults->firstWhere('student_id', Auth::user()->student->id) ?? null;
            $score = $quizResult ? $quizResult->score : null;
            $badgeClass =
                $score === null
                    ? 'bg-secondary'
                    : ($score < 50
                        ? 'bg-danger'
                        : ($score <= 80
                            ? 'bg-warning text-dark'
                            : 'bg-success'));
        @endphp

        {{-- Display score in a badge or fallback message --}}
        <p>
            <strong>Your Score:</strong>
            @if ($score !== null)
                <span class="badge {{ $badgeClass }}">{{ $score }}%</span>
            @else
                <span class="badge bg-secondary">No score available</span>
            @endif
        </p>

        {{-- Iterate through questions --}}
        @foreach ($quiz->questions as $question)
            <div class="mb-4 border rounded p-3 bg-light">
                {{-- Display question text --}}
                <h5 class="mb-3">{{ $question->question_text }}</h5>

                {{-- Display question image if available --}}
                @if ($question->image)
                    <img src="{{ asset('storage/' . $question->image) }}" alt="Question Image" class="img-fluid mb-3">
                @endif

                {{-- Handle answers based on question type --}}
                @if (in_array($question->question_type, ['', 'single_choice', 'multiple_choice']))
                    @foreach ($question->choices as $choice)
                        <div class="mb-2">
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
                        $studentAnswer = $question->answers->where('student_id', Auth::user()->student->id)->first();
                    @endphp
                    <p>
                        <strong>Your Answer:</strong> {{ $studentAnswer->answer_text ?? 'Not Answered' }}
                    </p>
                @endif
            </div>
        @endforeach
    </div>
@endsection
