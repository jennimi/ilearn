@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-primary">{{ $assignment->title }}</h1>
        <p class="text-muted">{{ $assignment->description }}</p>

        <div class="mb-4">
            <h5>Module: {{ $assignment->module->title }}</h5>
            <p>Course: {{ $assignment->module->course->title }}</p>
            <p>Deadline:
                <span class="{{ now()->greaterThan($assignment->deadline) ? 'text-danger' : 'text-success' }}">
                    {{ $assignment->deadline->format('Y-m-d H:i') }}
                </span>
            </p>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <h5>Submit Your Assignment</h5>
                <form action="{{ route('student.assignments.submit', $assignment->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="submission_file" class="form-label">Upload File</label>
                        <input type="file" name="submission_file" id="submission_file" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Assignment</button>
                </form>
            </div>
        </div>
    </div>
@endsection
