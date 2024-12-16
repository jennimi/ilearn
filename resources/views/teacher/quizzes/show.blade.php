@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $quiz->title }}</h1>
        <p>{{ $quiz->description }}</p>

        <div class="d-flex justify-content-end mb-4">
            <a href="{{ route('teacher.quizzes.edit', $quiz->id) }}" class="btn btn-outline-primary">
                <i class="bi bi-pencil"></i> Edit Quiz
            </a>
        </div>

        <h3>Questions</h3>
        @if ($quiz->questions->isEmpty())
            <p>No questions added yet.</p>
        @else
            @foreach ($quiz->questions as $question)
                <div class="card mb-3">
                    <div class="card-body">
                        <!-- Question Title -->
                        <h5 class="card-title">Question {{ $loop->iteration }}</h5>
                        <p><strong>Question Text:</strong> {{ $question->question_text }}</p>

                        <!-- Question Image (if available) -->
                        @if ($question->image)
                            <img src="{{ asset('storage/' . $question->image) }}" alt="Question Image" class="img-fluid mb-3">
                        @endif

                        <!-- Question Type and Points -->
                        <p><strong>Type:</strong>
                            {{ $question->getTypeLabel() }}
                        </p>
                        <p><strong>Points: </strong> {{ $question->points }}</p>

                        <!-- Choices or Correct Answer -->

                        @if ($question->choices->isNotEmpty())
                            <ul>
                                @foreach ($question->choices as $choice)
                                    <li>
                                        {{ $choice->choice_text }}
                                        @if ($choice->is_correct)
                                            <span class="badge bg-success">Correct</span>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p>No choices available for this question.</p>
                        @endif

                    </div>
                </div>
            @endforeach
        @endif
    </div>
@endsection
