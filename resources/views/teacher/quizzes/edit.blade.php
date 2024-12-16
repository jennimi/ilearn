@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">
            Edit Quiz
            <small class="text-muted">({{ $quiz->module->course->name }} - {{ $quiz->module->name }})</small>
        </h1>

        <!-- Delete Quiz Button -->
        <button type="button" class="btn btn-outline-danger mb-4" data-bs-toggle="modal" data-bs-target="#deleteQuizModal">
            <i class="bi bi-trash"></i> Delete Quiz
        </button>

        <form method="POST" action="{{ route('teacher.quizzes.update', $quiz->id) }}" id="editQuizForm">
            @csrf
            @method('PUT')

            <!-- Quiz Details -->
            <div class="mb-4">
                <label for="title" class="form-label">Quiz Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ $quiz->title }}" required>
            </div>

            <div class="mb-4">
                <label for="description" class="form-label">Quiz Description</label>
                <textarea class="form-control" id="description" name="description" rows="3">{{ $quiz->description }}</textarea>
            </div>

            <div class="mb-4">
                <label for="deadline" class="form-label">Quiz Deadline</label>
                <input type="datetime-local" class="form-control" id="deadline" name="deadline"
                    value="{{ $quiz->deadline ? $quiz->deadline->format('Y-m-d\TH:i') : '' }}" required>
            </div>

            <div class="mb-4">
                <label for="duration" class="form-label">Duration (Minutes)</label>
                <input type="number" class="form-control" id="duration" name="duration" min="1" value="{{ $quiz->duration }}" required>
            </div>

            <!-- Questions Section -->
            <div class="mb-4">
                <h4>Questions</h4>
                <button type="button" class="btn btn-outline-primary mb-3" data-bs-toggle="modal"
                    data-bs-target="#addQuestionModal">
                    <i class="bi bi-plus-circle"></i> Add Question
                </button>

                <div id="questionsContainer">
                    @foreach ($quiz->questions as $question)
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5>Question {{ $loop->iteration }}</h5>
                                <p><strong>Text:</strong> {{ $question->question_text }}</p>
                                <p><strong>Points:</strong> {{ $question->points }}</p>
                                <p><strong>Type:</strong> {{ $question->getTypeLabel() }}</p>
                                @if ($question->image)
                                    <img src="{{ asset('storage/' . $question->image) }}" alt="Question Image" class="img-fluid mb-3">
                                @endif
                                <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#editQuestionModal{{ $question->id }}">
                                    Edit
                                </button>
                                <form action="{{ route('teacher.questions.destroy', $question->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="btn btn-success">Save Changes</button>
        </form>
    </div>

    <!-- Add Question Modal -->
    <div class="modal fade" id="addQuestionModal" tabindex="-1" aria-labelledby="addQuestionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="addQuestionForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addQuestionModalLabel">Add Question</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="question_text" class="form-label">Question Text</label>
                            <textarea class="form-control" id="question_text" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="question_points" class="form-label">Points</label>
                            <input type="number" class="form-control" id="question_points" placeholder="Points for this question" min="1" required>
                        </div>
                        <div class="mb-3">
                            <label for="question_image" class="form-label">Question Image (Optional)</label>
                            <input type="file" class="form-control" id="question_image" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label for="question_type" class="form-label">Question Type</label>
                            <select class="form-select" id="question_type" required>
                                <option value="" disabled selected>Please choose question type</option>
                                <option value="0">Single Choice</option>
                                <option value="1">Multiple Choice</option>
                                <option value="2">Short Answer</option>
                            </select>
                        </div>
                        <div id="answerOptions" class="d-none">
                            <h6 class="mb-3">Answer Choices</h6>
                            <div id="answerFields"></div>
                            <button type="button" class="btn btn-outline-secondary add-answer"><i class="bi bi-plus-circle"></i> Add Another Answer</button>
                        </div>
                        <div id="correctAnswerField" class="d-none">
                            <label for="short_correct_answer" class="form-label">Correct Answer (Short Answer)</label>
                            <input type="text" class="form-control" id="short_correct_answer" placeholder="Enter the correct answer">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="saveQuestionButton">Save Question</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Question Modal -->
    @foreach ($quiz->questions as $question)
        <div class="modal fade" id="editQuestionModal{{ $question->id }}" tabindex="-1"
            aria-labelledby="editQuestionModalLabel{{ $question->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" action="{{ route('teacher.questions.update', $question->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editQuestionModalLabel{{ $question->id }}">Edit Question</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="question_text_{{ $question->id }}" class="form-label">Question Text</label>
                                <textarea class="form-control" id="question_text_{{ $question->id }}" name="question_text" rows="3" required>{{ $question->question_text }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="question_points_{{ $question->id }}" class="form-label">Points</label>
                                <input type="number" class="form-control" id="question_points_{{ $question->id }}" name="points" value="{{ $question->points }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="question_image_{{ $question->id }}" class="form-label">Question Image (Optional)</label>
                                <input type="file" class="form-control" id="question_image_{{ $question->id }}" name="image" accept="image/*">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endforeach

    <!-- Delete Quiz Modal -->
    <div class="modal fade" id="deleteQuizModal" tabindex="-1" aria-labelledby="deleteQuizModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('teacher.quizzes.destroy', $quiz->id) }}">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteQuizModalLabel">Delete Quiz</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this quiz?</p>
                        <p class="text-danger">
                            This action will delete all questions and choices associated with the quiz and cannot be undone.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete Quiz</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
