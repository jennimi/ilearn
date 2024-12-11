@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Course: {{ $course->title }}</h1>

        <form method="POST" action="{{ route('admin.courses.update', $course->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="title" class="form-label">Course Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ $course->title }}" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Course Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required>{{ $course->description }}</textarea>
            </div>

            <div class="mb-3">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" class="form-control" id="start_date" name="start_date"
                    value="{{ $course->start_date }}" required>
            </div>

            <div class="mb-3">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $course->end_date }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="teacher_id" class="form-label">Assign Teacher</label>
                <select class="form-control" id="teacher_id" name="teacher_id" required>
                    @foreach ($teachers as $teacher)
                        <option value="{{ $teacher->id }}" {{ $teacher->id == $course->teacher_id ? 'selected' : '' }}>
                            {{ $teacher->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <h3>Classrooms</h3>
            @foreach ($classrooms as $classroom)
                <div class="form-check mb-2">
                    <input type="checkbox" class="form-check-input classroom-checkbox" id="classroom_{{ $classroom->id }}"
                        name="classrooms[]" value="{{ $classroom->id }}"
                        {{ $course->classrooms->contains($classroom->id) ? 'checked' : '' }}>
                    <label class="form-check-label" for="classroom_{{ $classroom->id }}">
                        {{ $classroom->name }}
                    </label>

                    <div class="schedule-fields mt-2"
                        style="{{ $course->classrooms->contains($classroom->id) ? '' : 'display:none;' }}">
                        <label>Day:</label>
                        <select name="schedule[{{ $classroom->id }}][day]" class="form-control">
                            @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                <option value="{{ $day }}"
                                    {{ $course->classrooms->find($classroom->id)?->pivot?->day == $day ? 'selected' : '' }}>
                                    {{ $day }}
                                </option>
                            @endforeach
                        </select>

                        <label>Start Time:</label>
                        <input type="time" name="schedule[{{ $classroom->id }}][start_time]" class="form-control"
                            value="{{ $course->classrooms->find($classroom->id)?->pivot?->start_time }}">

                        <label>End Time:</label>
                        <input type="time" name="schedule[{{ $classroom->id }}][end_time]" class="form-control"
                            value="{{ $course->classrooms->find($classroom->id)?->pivot?->end_time }}">
                    </div>
                </div>
            @endforeach

            <button type="submit" class="btn btn-success">Update Course</button>
        </form>
    </div>

    <script>
        const classroomCheckboxes = document.querySelectorAll('.classroom-checkbox');
        classroomCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const scheduleFields = this.closest('div').querySelector('.schedule-fields');
                scheduleFields.style.display = this.checked ? 'block' : 'none';
            });
        });
    </script>
@endsection
