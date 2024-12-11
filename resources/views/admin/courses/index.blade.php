@extends('layouts.app')

@section('content')
<div class="container">
    <h1>All Courses</h1>

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
                        <td>{{ $course->title }}</td>
                        <td>{{ $course->teacher->name }}</td>
                        <td>
                            @foreach ($course->classrooms as $classroom)
                                <p>{{ $classroom->name }}</p>
                            @endforeach
                        </td>
                        <td>
                            @foreach ($course->classrooms as $classroom)
                                <p>
                                    {{ $classroom->pivot->day }}:
                                    {{ $classroom->pivot->start_time }} - {{ $classroom->pivot->end_time }}
                                </p>
                            @endforeach
                        </td>
                        <td>
                            <a href="{{ route('admin.courses.show', $course->id) }}" class="btn btn-primary btn-sm">View</a>
                            <a href="{{ route('admin.courses.edit', $course->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('admin.courses.destroy', $course->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
