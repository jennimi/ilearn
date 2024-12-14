@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-primary">{{ $quiz->title }}</h1>
        <p class="text-muted">{{ $quiz->description }}</p>

        <form id="quizForm" action="{{ route('student.quizzes.submit', $quiz->id) }}" method="POST">
            @csrf

            <div id="questionsContainer">
                @foreach ($quiz->questions as $index => $question)
                    <div class="question" data-question-id="{{ $question->id }}" data-index="{{ $index }}"
                        style="display: none;">
                        <h5>{{ $question->question_text }}</h5>
                        @if ($question->image)
                            <img src="{{ asset('storage/' . $question->image) }}" alt="Question Image"
                                class="img-fluid mb-3">
                        @endif

                        <p><strong>Type:</strong> {{ $question->getTypeLabel() }}</p>

                        @if ($question->getTypeLabel() === 'Single Choice')
                            <div class="choices">
                                @foreach ($question->choices as $choice)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio"
                                            name="answers[{{ $question->id }}]"
                                            value="{{ $choice->id }}"
                                            id="choice{{ $choice->id }}">
                                        <label class="form-check-label" for="choice{{ $choice->id }}">
                                            {{ $choice->choice_text }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        @elseif ($question->getTypeLabel() === 'Multiple Choice')
                            <div class="choices">
                                @foreach ($question->choices as $choice)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                            name="answers[{{ $question->id }}][]"
                                            value="{{ $choice->id }}"
                                            id="choice{{ $choice->id }}">
                                        <label class="form-check-label" for="choice{{ $choice->id }}">
                                            {{ $choice->choice_text }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        @elseif ($question->getTypeLabel() === 'Short Answer')
                            <div class="choices">
                                <input type="text" name="answers[{{ $question->id }}]"
                                    class="form-control"
                                    placeholder="Type your answer here">
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <button type="button" id="startQuizButton" class="btn btn-primary">Start Quiz</button>
            <button type="button" id="previousQuestionButton" class="btn btn-secondary" style="display: none;">Previous</button>
            <button type="button" id="nextQuestionButton" class="btn btn-secondary" style="display: none;">Next</button>
            <button type="submit" id="submitQuizButton" class="btn btn-success" style="display: none;">Submit Quiz</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const startButton = document.getElementById('startQuizButton');
            const previousButton = document.getElementById('previousQuestionButton');
            const nextButton = document.getElementById('nextQuestionButton');
            const submitButton = document.getElementById('submitQuizButton');
            const questions = Array.from(document.querySelectorAll('.question'));
            let currentQuestionIndex = 0;

            function showQuestion(index) {
                questions.forEach((question, i) => {
                    question.style.display = i === index ? 'block' : 'none';
                });

                previousButton.style.display = index > 0 ? 'inline-block' : 'none';
                nextButton.style.display = index < questions.length - 1 ? 'inline-block' : 'none';
                submitButton.style.display = index === questions.length - 1 ? 'inline-block' : 'none';
            }

            startButton.addEventListener('click', function () {
                startButton.style.display = 'none';
                showQuestion(currentQuestionIndex);
            });

            previousButton.addEventListener('click', function () {
                if (currentQuestionIndex > 0) {
                    currentQuestionIndex--;
                    showQuestion(currentQuestionIndex);
                }
            });

            nextButton.addEventListener('click', function () {
                if (currentQuestionIndex < questions.length - 1) {
                    currentQuestionIndex++;
                    showQuestion(currentQuestionIndex);
                }
            });
        });
    </script>
@endsection
