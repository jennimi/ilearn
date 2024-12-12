@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Classrooms</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('admin.classrooms.create') }}" class="btn btn-primary mb-3">Create Classroom</a>

        @if ($classrooms->isEmpty())
            <p>No courses available. <a href="{{ route('admin.courses.create') }}">Create a Course</a></p>
        @else
            <div class="row">
                @foreach ($classrooms as $classroom)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">{{ $classroom->name }}</h5>
                                <p class="card-text">Time Period: {{ $classroom->time_period }}</p>
                                <p class="card-text">Homeroom Teacher: {{ $classroom->teacher->name }}</p>
                                <a href="{{ route('admin.classrooms.show', $classroom->id) }}" class="btn btn-primary">View
                                    Classroom</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
