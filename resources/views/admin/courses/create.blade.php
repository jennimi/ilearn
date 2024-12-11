@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create Course</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.courses.store') }}">
            @csrf

            <div class="mb-3">
                <label for="title" class="form-label">Course Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Course Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>

            <div class="mb-3">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" class="form-control" id="start_date" name="start_date" required>
            </div>

            <div class="mb-3">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" class="form-control" id="end_date" name="end_date" required>
            </div>

            <div class="mb-3">
                <label for="teacher_id" class="form-label">Assign Teacher</label>
                <select class="form-control" id="teacher_id" name="teacher_id" required>
                    <option value="">-- Select Teacher --</option>
                    @foreach ($teachers as $teacher)
                        <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="classrooms" class="form-label">Assign Classrooms</label>
                <div id="classroom-assignments">
                    @foreach ($classrooms as $classroom)
                        <div class="form-check mb-2">
                            <input type="checkbox" class="form-check-input classroom-checkbox"
                                id="classroom_{{ $classroom->id }}" name="classrooms[]" value="{{ $classroom->id }}">
                            <label class="form-check-label" for="classroom_{{ $classroom->id }}">
                                {{ $classroom->name }}
                            </label>

                            <!-- Schedule Inputs -->
                            <div class="schedule-fields mt-2" style="display: none;">
                                <label>Day:</label>
                                <select name="schedule[{{ $classroom->id }}][day]" class="form-control">
                                    <option value="Monday">Monday</option>
                                    <option value="Tuesday">Tuesday</option>
                                    <option value="Wednesday">Wednesday</option>
                                    <option value="Thursday">Thursday</option>
                                    <option value="Friday">Friday</option>
                                    <option value="Saturday">Saturday</option>
                                    <option value="Sunday">Sunday</option>
                                </select>

                                <label>Start Time:</label>
                                <input type="time" name="schedule[{{ $classroom->id }}][start_time]"
                                    class="form-control">

                                <label>End Time:</label>
                                <input type="time" name="schedule[{{ $classroom->id }}][end_time]" class="form-control">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="btn btn-success">Create Course</button>
        </form>
    </div>

    <script>
        const classroomCheckboxes = document.querySelectorAll('.classroom-checkbox');
        classroomCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const scheduleFields = this.closest('div').querySelector('.schedule-fields');
                if (this.checked) {
                    scheduleFields.style.display = 'block';
                    scheduleFields.querySelectorAll('input, select').forEach(field => field.disabled =
                        false);
                } else {
                    scheduleFields.style.display = 'none';
                    scheduleFields.querySelectorAll('input, select').forEach(field => field.disabled =
                        true);
                }
            });
        });

        document.addEventListener('DOMContentLoaded', () => {
            classroomCheckboxes.forEach(checkbox => {
                const scheduleFields = checkbox.closest('div').querySelector('.schedule-fields');
                if (!checkbox.checked) {
                    scheduleFields.style.display = 'none';
                    scheduleFields.querySelectorAll('input, select').forEach(field => field.disabled =
                    true);
                }
            });
        });
    </script>
@endsection
