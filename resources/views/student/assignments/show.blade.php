@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-primary">{{ $assignment->title }}</h1>
        <p class="text-muted">{{ $assignment->description }}</p>

        <div class="mb-4">
            <h5>Modul: {{ $assignment->module->title }}</h5>
            <p>Mata Pelajaran: {{ $assignment->module->course->title }}</p>
            <p>Batas Waktu:
                <span class="{{ now()->greaterThan($assignment->deadline) ? 'text-danger' : 'text-success' }}">
                    {{ $assignment->deadline->format('Y-m-d H:i') }}
                </span>
            </p>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <h5>Unggah Tugas Anda</h5>
                @if ($submission)
                    <p class="text-success">Anda telah mengirimkan tugas ini pada {{ $submission->submission_date->format('Y-m-d H:i') }}.</p>
                    <p>File Tugas: <a href="{{ Storage::url($submission->file_path) }}" target="_blank">{{ basename($submission->file_path) }}</a></p>
                    @if ($submission->feedback)
                        <p><strong>Feedback:</strong> {{ $submission->feedback }}</p>
                    @endif
                    @if ($submission->grade)
                        <p><strong>Nilai:</strong> {{ $submission->grade }}</p>
                    @endif
                @else
                    <form action="{{ route('student.assignments.submit', $assignment->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="submission_file" class="form-label">Unggah File</label>
                            <input type="file" name="submission_file" id="submission_file" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Kirim Tugas</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection
