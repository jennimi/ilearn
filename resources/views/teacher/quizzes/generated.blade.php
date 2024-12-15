@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">
            AI-Generated Quiz
            <small class="text-muted">({{ $courseName }} - {{ $moduleName }})</small>
        </h1>
        <form method="POST" action="{{ route('teacher.quizzes.store', $module->id) }}" id="createQuizForm">
            @csrf

            <div class="mb-4">
                <label for="title" class="form-label">Quiz Title</label>
                <input type="text" class="form-control" id="title" name="title"
                    value="{{ $preFilledQuiz['title'] }}" required>
            </div>

            <div class="mb-4">
                <label for="description" class="form-label">Quiz Description</label>
                <textarea class="form-control" id="description" name="description" rows="3">{{ $preFilledQuiz['description'] }}</textarea>
            </div>

            <div class="mb-4">
                <label for="deadline" class="form-label">Quiz Deadline</label>
                <input type="datetime-local" class="form-control" id="deadline" name="deadline" required>
            </div>

            <div class="mb-4">
                <label for="duration" class="form-label">Duration (Minutes)</label>
                <input type="number" class="form-control" id="duration" name="duration" min="1" required>
            </div>

            <!-- Questions Section -->
            <div class="mb-4">
                <h4>Questions</h4>
                @foreach ($preFilledQuiz['questions'] as $index => $question)
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5>{{ $question['question_text'] }}</h5>
                            <ul>
                                @foreach ($question['choices'] as $choice)
                                    <li>
                                        {{ $choice['choice_text'] }}
                                        @if ($choice['is_correct'])
                                            <span class="badge bg-success">Correct</span>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endforeach

            </div>

            <button type="submit" class="btn btn-success">Save Quiz</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('createQuizForm');
            const questionsContainer = document.getElementById('questionsContainer');
            const questionsDataInput = document.getElementById('questionsData');
        });
    </script>
@endsection
