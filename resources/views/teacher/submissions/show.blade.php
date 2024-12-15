@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Submission Details</h1>
        <p><strong>Student Name:</strong> {{ $submission->student->name }}</p>
        <p><strong>Assignment:</strong> {{ $submission->assignment->title }}</p>
        <p><strong>Submission Date:</strong> {{ $submission->created_at->format('Y-m-d H:i') }}</p>
        <p><strong>Grade:</strong> {{ $submission->grade ?? 'Not Graded' }}</p>

        <div class="mt-4">
            <a href="{{ asset('storage/' . $submission->file) }}" target="_blank" class="btn btn-success">
                View Submission File
            </a>
        </div>
    </div>
@endsection
