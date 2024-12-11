@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Course Details: {{ $course->title }}</h1>

    <p><strong>Teacher:</strong> {{ $course->teacher->name }}</p>
    <p><strong>Description:</strong> {{ $course->description }}</p>
    <p><strong>Start Date:</strong> {{ $course->start_date }}</p>
    <p><strong>End Date:</strong> {{ $course->end_date }}</p>

    <h3>Classrooms</h3>
    @foreach ($course->classrooms as $classroom)
        <p>
            {{ $classroom->name }}<br>
            <p>
                {{ $classroom->pivot->day }}:
                {{ $classroom->pivot->start_time }} - {{ $classroom->pivot->end_time }}
            </p>
                    </p>
    @endforeach

    <a href="{{ route('admin.courses.edit', $course->id) }}" class="btn btn-warning">Edit Course</a>
    <form action="{{ route('admin.courses.destroy', $course->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Delete Course</button>
    </form>
</div>
@endsection
