@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-2 text-primary">{{ $course->title }}</h1>
        <p class="text-muted mb-3">{{ $course->description }}</p>

        <div class="mb-3">
            <h3 class="text-secondary">Classrooms</h3>
            <div class="row">
                @foreach ($course->classrooms as $classroom)
                    <div class="col-lg-2 col-md-3 col-sm-4 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-body text-center">
                                <h5 class="card-title">{{ $classroom->name }}</h5>
                                <p class="text-muted small">{{ $classroom->pivot->day }}</p>
                                <p class="text-muted small">
                                    {{ $classroom->pivot->start_time }} - {{ $classroom->pivot->end_time }}
                                </p>
                                <a href="{{ route('teacher.leaderboard', $classroom->id) }}" class="btn btn-primary btn-sm">
                                    View Leaderboard
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Modules and Lessons Section -->
        <div class="accordion" id="modulesAccordion">
            <h3 class="text-secondary">Modules</h3>
            @foreach ($course->modules as $module)
                <div class="accordion-item mb-3 shadow-sm border">
                    <h2 class="accordion-header" id="heading{{ $module->id }}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse{{ $module->id }}" aria-expanded="false"
                            aria-controls="collapse{{ $module->id }}">
                            <span class="fw-bold">{{ $module->title }}</span>
                            <span class="text-muted ms-2">{{ $module->description }}</span>
                        </button>
                    </h2>
                    <div id="collapse{{ $module->id }}" class="accordion-collapse collapse"
                        aria-labelledby="heading{{ $module->id }}" data-bs-parent="#modulesAccordion">
                        <div class="accordion-body">

                            <!-- Lessons Section -->
                            <h5 class="text-secondary">Lessons</h5>
                            @if ($module->lessons->isEmpty())
                                <p class="text-danger">No lessons available for this module.</p>
                            @else
                                <ul class="list-group mb-4">
                                    @foreach ($module->lessons as $lesson)
                                        <li class="list-group-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <strong>{{ $lesson->title }}</strong>
                                                    <div>
                                                        <span
                                                            class="badge bg-{{ $lesson->visible ? 'success' : 'danger' }}">
                                                            {{ $lesson->visible ? 'Visible' : 'Hidden' }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div>
                                                    <a href="{{ asset('storage/' . $lesson->content) }}" target="_blank"
                                                        class="btn btn-success btn-sm">
                                                        View Full PDF
                                                    </a>
                                                    <button type="button" class="btn btn-outline-primary btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editLessonModal{{ $lesson->id }}">
                                                        Edit
                                                    </button>
                                                    <button type="button" class="btn btn-outline-secondary btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#toggleVisibilityModal{{ $lesson->id }}">
                                                        Update Visibility
                                                    </button>
                                                    <button type="button" class="btn btn-outline-danger btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteLessonModal{{ $lesson->id }}">
                                                        Delete
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="mt-3">
                                                <div class="card shadow-sm">
                                                    <div class="card-body text-center">
                                                        <iframe
                                                            src="{{ asset('storage/' . $lesson->content) }}#toolbar=0&navpanes=0&scrollbar=0&zoom=50"
                                                            width="50%" height="200px" class="border rounded"></iframe>
                                                        <div class="mt-3">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal fade" id="editLessonModal{{ $lesson->id }}" tabindex="-1"
                                                aria-labelledby="editLessonModalLabel{{ $lesson->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <form method="POST"
                                                        action="{{ route('teacher.lessons.update', $lesson->id) }}"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="editLessonModalLabel{{ $lesson->id }}">Edit
                                                                    Lesson</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="editTitle{{ $lesson->id }}"
                                                                        class="form-label">Lesson Title</label>
                                                                    <input type="text" class="form-control"
                                                                        id="editTitle{{ $lesson->id }}" name="title"
                                                                        value="{{ $lesson->title }}" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="editContent{{ $lesson->id }}"
                                                                        class="form-label">Replace PDF (Optional)</label>
                                                                    <input type="file" class="form-control"
                                                                        id="editContent{{ $lesson->id }}" name="content"
                                                                        accept="application/pdf">
                                                                    <small class="text-muted">Leave empty to keep the
                                                                        current file.</small>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="editVisible{{ $lesson->id }}"
                                                                        class="form-label">Visible</label>
                                                                    <select class="form-control"
                                                                        id="editVisible{{ $lesson->id }}"
                                                                        name="visible">
                                                                        <option value="1"
                                                                            {{ $lesson->visible ? 'selected' : '' }}>Yes
                                                                        </option>
                                                                        <option value="0"
                                                                            {{ !$lesson->visible ? 'selected' : '' }}>No
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn btn-primary">Save
                                                                    Changes</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                            <div class="modal fade" id="deleteLessonModal{{ $lesson->id }}"
                                                tabindex="-1"
                                                aria-labelledby="deleteLessonModalLabel{{ $lesson->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <form method="POST"
                                                        action="{{ route('teacher.lessons.destroy', $lesson->id) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="deleteLessonModalLabel{{ $lesson->id }}">Delete
                                                                    Lesson</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Are you sure you want to delete the lesson
                                                                <strong>{{ $lesson->title }}</strong>? This action
                                                                cannot be undone.
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Cancel</button>
                                                                <button type="submit"
                                                                    class="btn btn-danger">Delete</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                            <!-- Toggle Visibility Modal -->
                                            <div class="modal fade" id="toggleVisibilityModal{{ $lesson->id }}"
                                                tabindex="-1"
                                                aria-labelledby="toggleVisibilityModalLabel{{ $lesson->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <form method="POST"
                                                        action="{{ route('teacher.lessons.update', $lesson->id) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="toggleVisibilityModalLabel{{ $lesson->id }}">
                                                                    Update Lesson Visibility
                                                                </h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Are you sure you want to
                                                                <strong>{{ $lesson->visible ? 'hide' : 'show' }}</strong>
                                                                this lesson to students?
                                                            </div>
                                                            <input type="hidden" name="visible"
                                                                value="{{ $lesson->visible ? 0 : 1 }}">
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Cancel</button>
                                                                <button type="submit"
                                                                    class="btn btn-primary">Confirm</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                            <div class="d-flex justify-content-end mb-3">
                                <button class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addLessonModal{{ $module->id }}">
                                    <i class="bi bi-plus-circle"></i> Add Lesson
                                </button>
                            </div>

                            <!-- Quizzes Section -->
                            <h5 class="text-secondary mt-4">Quizzes</h5>
                            @if ($module->quizzes->isEmpty())
                                <p class="text-danger">No quizzes available for this module.</p>
                            @else
                                <ul class="list-group mb-4">
                                    @foreach ($module->quizzes as $quiz)
                                        <li class="list-group-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <strong>{{ $quiz->title }}</strong>
                                                    <span
                                                        class="badge bg-{{ $quiz->visible ? 'success' : 'danger' }} ms-2">
                                                        {{ $quiz->visible ? 'Visible' : 'Hidden' }}
                                                    </span>
                                                </div>
                                                <div>
                                                    <a href="{{ route('teacher.quizzes.show', $quiz->id) }}"
                                                        class="btn btn-outline-success btn-sm">
                                                        View Quiz
                                                    </a>
                                                    <button type="button" class="btn btn-outline-secondary btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#toggleVisibilityModalQuiz{{ $quiz->id }}">
                                                        Update Visibility
                                                    </button>
                                                </div>
                                            </div>
                                        </li>

                                        <div class="modal fade" id="toggleVisibilityModalQuiz{{ $quiz->id }}"
                                            tabindex="-1"
                                            aria-labelledby="toggleVisibilityModalLabelQuiz{{ $quiz->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <form method="POST"
                                                    action="{{ route('teacher.quizzes.toggleVisibility', $quiz->id) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="toggleVisibilityModalLabelQuiz{{ $quiz->id }}">
                                                                Update Quiz Visibility
                                                            </h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are you sure you want to
                                                            <strong>{{ $quiz->visible ? 'hide' : 'show' }}</strong> this
                                                            quiz to
                                                            students?
                                                        </div>
                                                        <input type="hidden" name="visible"
                                                            value="{{ $quiz->visible ? 0 : 1 }}">
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit"
                                                                class="btn btn-primary">Confirm</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                </ul>
                            @endif

                            <!-- Generate Quiz with AI -->
                            <div class="d-flex justify-content-end mb-3">
                                <button type="button" class="btn btn-outline-primary tw-me-1" data-bs-toggle="modal"
                                    data-bs-target="#generateQuizModal{{ $module->id }}">
                                    <i class="bi bi-lightbulb"></i> Generate Quiz with AI
                                </button>
                                <a href="{{ route('teacher.quizzes.create', $module->id) }}" class="btn btn-primary">
                                    <i class="bi bi-file-earmark-text"></i> Create Quiz
                                </a>
                            </div>

                            <!-- Generate Quiz Modal -->
                            <div class="modal fade" id="generateQuizModal{{ $module->id }}" tabindex="-1"
                                aria-labelledby="generateQuizModalLabel{{ $module->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form action="{{ route('teacher.quizzes.generate', $module->id) }}" method="POST"
                                        enctype="multipart/form-data" onsubmit="showLoadingSpinner(event)">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="generateQuizModalLabel{{ $module->id }}">
                                                    Generate Quiz with AI</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="quizTitle" class="form-label">Quiz Title</label>
                                                    <input type="text" class="form-control" id="quizTitle"
                                                        name="quizTitle" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="file" class="form-label">Upload PDF</label>
                                                    <input type="file" class="form-control" id="file"
                                                        name="file" accept=".pdf">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="textContext" class="form-label">Or Paste Text
                                                        Context</label>
                                                    <textarea class="form-control" id="textContext" name="textContext" rows="4"></textarea>
                                                    <small class="text-muted">You can upload a PDF or paste text to
                                                        generate a quiz.</small>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" id="generateQuizButton" class="btn btn-primary">
                                                    <i class="bi bi-lightbulb"></i> Generate Quiz
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>


                            <!-- Assignments Section -->
                            <h5 class="text-secondary mt-4">Assignments</h5>
                            @if ($module->assignments->isEmpty())
                                <p class="text-danger">No assignments available for this module.</p>
                            @else
                                <ul class="list-group">
                                    @foreach ($module->assignments as $assignment)
                                        <li class="list-group-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <strong>{{ $assignment->title }}</strong>
                                                    <span
                                                        class="badge bg-{{ $assignment->visible ? 'success' : 'danger' }} ms-2">
                                                        {{ $assignment->visible ? 'Visible' : 'Hidden' }}
                                                    </span>
                                                </div>
                                                <div>
                                                    <a href="{{ route('teacher.assignments.show', $assignment->id) }}"
                                                        class="btn btn-outline-success btn-sm">
                                                        View Assignment
                                                    </a>
                                                    {{-- <button type="button" class="btn btn-outline-primary btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editAssignmentModal{{ $assignment->id }}">
                                                        Edit
                                                    </button> --}}
                                                    <button type="button" class="btn btn-outline-secondary btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#toggleVisibilityModalAssignment{{ $assignment->id }}">
                                                        Update Visibility
                                                    </button>
                                                </div>
                                            </div>
                                        </li>

                                        <div class="modal fade" id="toggleVisibilityModalAssignment{{ $assignment->id }}"
                                            tabindex="-1"
                                            aria-labelledby="toggleVisibilityModalLabelAssignment{{ $assignment->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <form method="POST"
                                                    action="{{ route('teacher.assignments.toggleVisibility', $assignment->id) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="toggleVisibilityModalLabelAssignment{{ $assignment->id }}">
                                                                Update Assignment Visibility
                                                            </h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are you sure you want to
                                                            <strong>{{ $assignment->visible ? 'hide' : 'show' }}</strong>
                                                            this
                                                            assignment to students?
                                                        </div>
                                                        <input type="hidden" name="visible"
                                                            value="{{ $assignment->visible ? 0 : 1 }}">
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit"
                                                                class="btn btn-primary">Confirm</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                    @endforeach
                                </ul>
                            @endif
                            <!-- Add Assignment Button -->
                            <div class="d-flex justify-content-end mb-3 tw-mt-5">
                                <button class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addAssignmentModal{{ $module->id }}">
                                    <i class="bi bi-plus-circle"></i> Add Assignment
                                </button>
                            </div>

                            <!-- Add Assignment Modal -->
                            <div class="modal fade" id="addAssignmentModal{{ $module->id }}" tabindex="-1"
                                aria-labelledby="addAssignmentModalLabel{{ $module->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form method="POST" action="{{ route('teacher.assignments.store', $module->id) }}">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="addAssignmentModalLabel{{ $module->id }}">
                                                    Add Assignment</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Title Field -->
                                                <div class="mb-3">
                                                    <label for="assignmentTitle{{ $module->id }}"
                                                        class="form-label">Assignment Title</label>
                                                    <input type="text" class="form-control"
                                                        id="assignmentTitle{{ $module->id }}" name="title" required>
                                                </div>
                                                <!-- Description Field -->
                                                <div class="mb-3">
                                                    <label for="assignmentDescription{{ $module->id }}"
                                                        class="form-label">Assignment Description</label>
                                                    <textarea class="form-control" id="assignmentDescription{{ $module->id }}" name="description" rows="3"
                                                        required></textarea>
                                                </div>
                                                <!-- Deadline Field -->
                                                <div class="mb-3">
                                                    <label for="assignmentDeadline{{ $module->id }}"
                                                        class="form-label">Deadline</label>
                                                    <input type="datetime-local" class="form-control"
                                                        id="assignmentDeadline{{ $module->id }}" name="deadline"
                                                        required>
                                                </div>
                                                <!-- Visibility Field -->
                                                <div class="mb-3">
                                                    <label for="assignmentVisible{{ $module->id }}"
                                                        class="form-label">Visible</label>
                                                    <select class="form-control"
                                                        id="assignmentVisible{{ $module->id }}" name="visible">
                                                        <option value="1">Yes</option>
                                                        <option value="0">No</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Add Assignment</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>


                            <!-- Add Lesson Modal -->
                            <div class="modal fade" id="addLessonModal{{ $module->id }}" tabindex="-1"
                                aria-labelledby="addLessonModalLabel{{ $module->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form method="POST" action="{{ route('teacher.lessons.store', $module->id) }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="addLessonModalLabel{{ $module->id }}">Add
                                                    Lesson</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="title" class="form-label">Lesson Title</label>
                                                    <input type="text" class="form-control" id="title"
                                                        name="title" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="content" class="form-label">Upload PDF</label>
                                                    <input type="file" class="form-control" id="content"
                                                        name="content" accept="application/pdf" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="visible" class="form-label">Visible</label>
                                                    <select class="form-control" id="visible" name="visible">
                                                        <option value="1">Yes</option>
                                                        <option value="0">No</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Add Lesson</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Link to Discussion -->
                            @if ($module->discussion)
                                <div class="mb-4 text-end tw-mt-10">
                                    <a href="{{ route('discussions.show', $module->discussion->id) }}"
                                        class="btn btn-outline-primary">
                                        <i class="bi bi-chat-text"></i> Go to Discussion
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>


        <!-- Add Module Button -->
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModuleModal">Add Module</button>

        <!-- Add Module Modal -->
        <div class="modal fade" id="addModuleModal" tabindex="-1" aria-labelledby="addModuleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" action="{{ route('teacher.modules.store', $course->id) }}">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addModuleModalLabel">Add Module</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="title" class="form-label">Module Title</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Module Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add Module</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add JavaScript -->
    <script>
        // Function to handle the form submission and show the spinner
        function showLoadingSpinner(event) {
            console.log('Spinner function triggered'); // Debugging log

            // Prevent the default form submission to observe the spinner in action
            event.preventDefault();

            // Get the submit button
            const button = document.getElementById('generateQuizButton');

            // Disable the button and change its content to a spinner
            if (button) {
                button.disabled = true;
                button.innerHTML = `
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Generating...
                `;
            }

            // Optionally submit the form after showing the spinner
            // Uncomment the next line if you want the form to be submitted
            // after the spinner is displayed.
            // event.target.submit();
        }

        // Function to reset the button state when the page loads
        window.onload = function () {
            console.log('Page loaded, resetting button state'); // Debugging log

            // Reset the submit button to its original state
            const button = document.getElementById('generateQuizButton');
            if (button) {
                button.disabled = false;
                button.innerHTML = 'Generate Quiz'; // Reset the content
            }
        };
    </script>

@endsection
