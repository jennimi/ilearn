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
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $module->id }}" aria-expanded="false" aria-controls="collapse{{ $module->id }}">
                        {{ $module->title }}
                    </button>
                </h2>
                <div id="collapse{{ $module->id }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $module->id }}" data-bs-parent="#modulesAccordion">
                    <div class="accordion-body">
                        <p>{{ $module->description }}</p>

                        <h5>Lessons</h5>
                        @if ($module->lessons->isEmpty())
                            <p>No lessons available for this module.</p>
                        @else
                            <ul>
                                @foreach ($module->lessons as $lesson)
                                    <li>
                                        <strong>{{ $lesson->title }}</strong>
                                        <p>{{ Str::limit($lesson->content, 100) }}</p>
                                        <p>Visible: {{ $lesson->visible ? 'Yes' : 'No' }}</p>
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                        <!-- Link to Discussion -->
                        <p>
                            <a href="{{ route('teacher.discussions.show', $module->discussion->id) }}" class="btn btn-link">Go to Discussion</a>
                        </p>
                    </div>

                </div>
            </div>
        @endforeach
    </div>

    <!-- Add Module Button -->
    <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#addModuleModal">Add Module</button>

    <!-- Add Module Modal -->
    <div class="modal fade" id="addModuleModal" tabindex="-1" aria-labelledby="addModuleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('teacher.modules.store', $course->id) }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModuleModalLabel">Add Module</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
