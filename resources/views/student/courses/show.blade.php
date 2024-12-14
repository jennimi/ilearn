@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4 text-primary">{{ $course->title }}</h1>
        <p class="text-muted">{{ $course->description }}</p>

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
                                        @if ($lesson->visible)
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
                                                        <a href="{{ asset('storage/' . $lesson->content) }}"
                                                            target="_blank" class="btn btn-success btn-sm">
                                                            View Full PDF
                                                        </a>
                                                    </div>
                                                </div>

                                                <!-- Inline PDF Preview -->
                                                <div class="mt-3">
                                                    <div class="card shadow-sm">
                                                        <div class="card-body text-center">
                                                            <iframe
                                                                src="{{ asset('storage/' . $lesson->content) }}#toolbar=0&navpanes=0&scrollbar=0"
                                                                width="50%" height="200px" class="border rounded">
                                                            </iframe>
                                                            <div class="mt-3">
                                                                <a href="{{ asset('storage/' . $lesson->content) }}"
                                                                    target="_blank" class="btn btn-primary btn-sm">
                                                                    Open in Full View
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            @endif


                            <!-- Quizzes Section -->
                            <h5 class="text-secondary">Quizzes</h5>
                            @if ($module->quizzes->isEmpty())
                                <p class="text-danger">No quizzes available for this module.</p>
                            @else
                                <ul class="list-group mb-4">
                                    @foreach ($module->quizzes as $quiz)
                                        <li class="list-group-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <strong>{{ $quiz->title }}</strong>
                                                    <p class="text-muted">{{ $quiz->description }}</p>
                                                </div>
                                                <a href="{{ route('student.quizzes.take', $quiz->id) }}"
                                                    class="btn btn-outline-success btn-sm">
                                                    Take Quiz
                                                </a>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif

                            <!-- Assignments Section -->
                            <h5 class="text-secondary">Assignments</h5>
                            @if ($module->assignments->isEmpty())
                                <p class="text-danger">No assignments available for this module.</p>
                            @else
                                <ul class="list-group mb-4">
                                    @foreach ($module->assignments as $assignment)
                                        <li class="list-group-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <strong>{{ $assignment->title }}</strong>
                                                    <p class="text-muted">{{ $assignment->description }}</p>
                                                    <p class="text-muted">
                                                        Deadline:
                                                        <span
                                                            class="{{ now()->greaterThan($assignment->deadline) ? 'text-danger' : 'text-success' }}">
                                                            {{ $assignment->deadline->format('Y-m-d H:i') }}
                                                        </span>
                                                    </p>
                                                </div>
                                                <a href="{{ route('student.assignments.show', $assignment->id) }}"
                                                    class="btn btn-outline-primary btn-sm">
                                                    View Assignment
                                                </a>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif


                            <!-- Link to Discussion -->
                            @if ($module->discussion)
                                <div class="mt-4 text-end">
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
    </div>
@endsection
