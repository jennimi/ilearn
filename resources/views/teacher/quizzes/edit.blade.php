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
                    value="{{ $quiz->deadline ? $quiz->deadline->format('Y-m-d\TH:i') : '' }}">
            </div>

            <div class="mb-4">
                <label for="duration" class="form-label">Duration (Minutes)</label>
                <input type="number" class="form-control" id="duration" name="duration" min="1"
                    value="{{ $quiz->duration }}">
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
                                    <img src="{{ asset('storage/' . $question->image) }}" alt="Question Image"
                                        class="img-fluid mb-3">
                                @endif

                                <!-- Display Question Choices -->
                                <h6>Choices:</h6>
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

                                <!-- Action Buttons -->
                                <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#editQuestionModal{{ $question->id }}">
                                    Edit
                                </button>
                                <form action="{{ route('teacher.questions.destroy', $question->id) }}" method="POST"
                                    class="d-inline">
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
                        <!-- Similar to the "Create Quiz" modal structure -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save Question</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Question Modal -->
    @foreach ($quiz->questions as $question)
        <div class="modal fade" id="editQuestionModal{{ $question->id }}" tabindex="-1"
            aria-labelledby="editQuestionModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" action="{{ route('teacher.questions.update', $question->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editQuestionModalLabel">Edit Question</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Question Text -->
                            <div class="mb-3">
                                <label for="edit_question_text_{{ $question->id }}" class="form-label">Question Text</label>
                                <textarea class="form-control" id="edit_question_text_{{ $question->id }}" name="question_text" rows="3"
                                    required>{{ $question->question_text }}</textarea>
                            </div>

                            <!-- Question Points -->
                            <div class="mb-3">
                                <label for="edit_question_points_{{ $question->id }}" class="form-label">Points</label>
                                <input type="number" class="form-control" id="edit_question_points_{{ $question->id }}"
                                    name="points" value="{{ $question->points }}" required>
                            </div>

                            <!-- Question Type -->
                            <div class="mb-3">
                                <label for="edit_question_type_{{ $question->id }}" class="form-label">Question Type</label>
                                <select class="form-select" id="edit_question_type_{{ $question->id }}"
                                    name="question_type" required>
                                    <option value="0" {{ $question->type == 0 ? 'selected' : '' }}>Single Choice</option>
                                    <option value="1" {{ $question->type == 1 ? 'selected' : '' }}>Multiple Choice</option>
                                    <option value="2" {{ $question->type == 2 ? 'selected' : '' }}>Short Answer</option>
                                </select>
                            </div>

                            <!-- Question Choices -->
                            <div id="edit_question_choices_{{ $question->id }}">
                                <h6>Choices</h6>
                                @foreach ($question->choices as $choice)
                                    <div class="mb-3 d-flex align-items-center">
                                        <input type="text" class="form-control me-2"
                                            name="choices[{{ $choice->id }}][choice_text]"
                                            value="{{ $choice->choice_text }}" required>
                                        <input type="hidden" name="choices[{{ $choice->id }}][id]"
                                            value="{{ $choice->id }}">
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" class="form-check-input"
                                                id="is_correct_{{ $choice->id }}"
                                                name="choices[{{ $choice->id }}][is_correct]" value="1"
                                                {{ $choice->is_correct ? 'checked' : '' }} hidden>
                                            <label class="form-check-label"
                                                for="is_correct_{{ $choice->id }}">Correct</label>
                                        </div>
                                        <button type="button" class="btn btn-danger btn-sm remove-choice" onclick="this.parentElement.remove();">
                                            <i class="bi bi-x-circle"></i> Remove
                                        </button>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Add New Choice Button -->
                            <button type="button" class="btn btn-outline-secondary btn-sm"
                                id="addChoiceBtn_{{ $question->id }}" onclick="addChoiceField({{ $question->id }})">
                                <i class="bi bi-plus-circle"></i> Add Another Choice
                            </button>
                            <div id="newChoicesContainer_{{ $question->id }}"></div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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

<script>
    function addChoiceField(questionId) {
        const container = document.getElementById(`newChoicesContainer_${questionId}`);
        const newField = document.createElement('div');
        newField.classList.add('mb-3', 'd-flex', 'align-items-center');
        newField.innerHTML = `
            <input type="text" class="form-control me-2" name="new_choices[${questionId}][]" placeholder="Enter choice text" required>
            <div class="form-check form-check-inline">
                <input type="checkbox" class="form-check-input" name="new_choices_correct[${questionId}][]" value="1">
                <label class="form-check-label">Correct</label>
            </div>
            <button type="button" class="btn btn-danger btn-sm remove-choice" onclick="this.parentElement.remove();">
                <i class="bi bi-x-circle"></i> Remove
            </button>
        `;
        container.appendChild(newField);
    }
</script>
