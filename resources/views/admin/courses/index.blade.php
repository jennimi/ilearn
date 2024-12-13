@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>All Courses</h1>
            @if (!$courses->isEmpty())
                <div>
                    <a href="{{ route('admin.courses.create') }}" class="btn btn-primary me-2">Create Course</a>
                </div>
            @endif
        </div>


        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($courses->isEmpty())
            <p>No courses available. <a href="{{ route('admin.courses.create') }}">Create a Course</a></p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Teacher</th>
                        <th>Classrooms</th>
                        <th>Schedule</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($courses as $course)
                        <tr>
                            <td >{{ $course->title }}</td>
                            <td >{{ $course->teacher->name }}</td>
                            <td >
                                @foreach ($course->classrooms as $classroom)
                                    <p>{{ $classroom->name }}</p>
                                @endforeach
                            </td>
                            <td >
                                @foreach ($course->classrooms as $classroom)
                                    <p>
                                        {{ $classroom->pivot->day }}:
                                        {{ $classroom->pivot->start_time }} - {{ $classroom->pivot->end_time }}
                                    </p>
                                @endforeach
                            </td>
                            <td>
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('admin.courses.show', $course->id) }}" class="btn btn-primary btn-sm flex-fill me-1">View</a>
                                    <a href="{{ route('admin.courses.edit', $course->id) }}" class="btn btn-warning btn-sm flex-fill me-1">Edit</a>
                                    <form action="{{ route('admin.courses.destroy', $course->id) }}" method="POST" class="flex-fill">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm w-100">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
