@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $course->title }}</h1>
        <p>{{ $course->description }}</p>

        <!-- Classrooms Section -->
        <h3>Classrooms</h3>
        <ul>
            @foreach ($course->classrooms as $classroom)
                <li>
                    {{ $classroom->name }} -
                    {{ $classroom->pivot->day }}:
                    {{ $classroom->pivot->start_time }} - {{ $classroom->pivot->end_time }}
                </li>
            @endforeach
        </ul>

        <!-- Modules and Lessons Section -->
        <h3>Modules</h3>
        <div class="accordion" id="modulesAccordion">
            @foreach ($course->modules as $module)
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading{{ $module->id }}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse{{ $module->id }}" aria-expanded="false"
                            aria-controls="collapse{{ $module->id }}">
                            {{ $module->title }}
                        </button>
                    </h2>
                    <div id="collapse{{ $module->id }}" class="accordion-collapse collapse"
                        aria-labelledby="heading{{ $module->id }}" data-bs-parent="#modulesAccordion">
                        <div class="accordion-body">
                            <p>{{ $module->description }}</p>

                            <!-- Link to Discussion -->
                            <p>
                                <a href="{{ $module->discussion ? route('discussions.show', $module->discussion->id) : '#' }}"
                                    class="btn btn-link">
                                    Go
                                    to Discussion</a>
                            </p>

                            <h5>Lessons</h5>
                            @if ($module->lessons->isEmpty())
                                <p>No lessons available for this module.</p>
                            @else
                                <ul>
                                    @foreach ($module->lessons as $lesson)
                                        <li>
                                            <strong>{{ $lesson->title }}</strong>
                                            <p>Visible to Students:
                                                <button type="button"
                                                    class="btn btn-outline-{{ $lesson->visible ? 'success' : 'danger' }} btn-sm"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#toggleVisibilityModal{{ $lesson->id }}">
                                                    {{ $lesson->visible ? 'Visible' : 'Hidden' }}
                                                </button>
                                            </p>

                                            <!-- PDF Snippet -->
                                            <div style="border: 1px solid #ddd; padding: 10px; margin-bottom: 10px;">
                                                <iframe
                                                    src="{{ asset('storage/' . $lesson->content) }}#toolbar=0&navpanes=0&scrollbar=0&zoom=50"
                                                    width="50%" height="200px">
                                                </iframe>
                                            </div>

                                            <a href="{{ asset('storage/' . $lesson->content) }}" target="_blank"
                                                class="btn btn-sm btn-success">View Full PDF</a>

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
                                                                this
                                                                lesson to students?
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

                            <!-- Quizzes Section -->
                            <h5>Quizzes</h5>
                            @if ($module->quizzes->isEmpty())
                                <p>No quizzes available for this module.</p>
                            @else
                                <ul>
                                    @foreach ($module->quizzes as $quiz)
                                        <li>
                                            <strong>{{ $quiz->title }}</strong>
                                            <p>{{ $quiz->description }}</p>
                                            <a href="{{ route('teacher.quizzes.show', $quiz->id) }}"
                                                class="btn btn-sm btn-success">View Quiz</a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif

                            <!-- Add Lesson Button -->
                            <button class="btn btn-primary mt-3" data-bs-toggle="modal"
                                data-bs-target="#addLessonModal{{ $module->id }}">Add Lesson</button>

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
                                                    <input type="text" class="form-control" id="title" name="title"
                                                        required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="content" class="form-label">Upload PDF</label>
                                                    <input type="file" class="form-control" id="content" name="content"
                                                        accept="application/pdf" required>
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

                            <!-- Create Quiz Button -->
                            <a href="{{ route('teacher.quizzes.create', $module->id) }}"
                                class="btn btn-primary mt-3">Create Quiz</a>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>


        <!-- Add Module Button -->
        <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#addModuleModal">Add Module</button>

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
@endsection
