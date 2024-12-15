@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h1>{{ $classroom->name }}</h1>
            <div>
                <a href="{{ route('admin.classrooms.edit', $classroom->id) }}" class="btn btn-warning">Edit Classroom</a>
                <a href="{{ route('admin.classrooms.addStudents', $classroom->id) }}" class="btn btn-success">Add Students</a>
            </div>
        </div>
        <p>Time Period: {{ $classroom->time_period }}</p>
        <p>Homeroom Teacher: {{ $classroom->teacher->name }}</p>

        <h3>Students</h3>
        @if ($classroom->students->isEmpty())
            <div class="text-center">
                <p>No students assigned to this classroom.</p>
            </div>
        @else
            <div class="row">
                @foreach ($students as $student)
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-sm border-0">
                            <div class="card-body">
                                <h5 class="card-title text-primary">{{ $student->name }}</h5>
                                <p class="card-text">NIK: {{ $student->nik }}</p>
                                <p class="card-text">Email: {{ $student->email }}</p>
                                <p class="card-text">
                                    <span class="badge bg-success">{{ ucfirst($student->role) }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination Links -->
            <div class="d-flex justify-content-center mt-4">
                {{ $students->links('pagination::bootstrap-4') }}
            </div>
        @endif
    </div>
@endsection
