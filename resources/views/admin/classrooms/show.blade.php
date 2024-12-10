@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $classroom->name }}</h1>
    <p>Time Period: {{ $classroom->time_period }}</p>
    <p>Homeroom Teacher: {{ $classroom->teacher->name }}</p>

    <h3>Students</h3>
    @if ($classroom->students->isEmpty())
        <p>No students assigned to this classroom.</p>
    @else
        <ul>
            @foreach ($classroom->students as $student)
                <li>{{ $student->name }} ({{ $student->email }})</li>
            @endforeach
        </ul>
    @endif

    <a href="{{ route('admin.classrooms.edit', $classroom->id) }}" class="btn btn-warning">Edit Classroom</a>
    <a href="{{ route('admin.classrooms.addStudents', $classroom->id) }}" class="btn btn-success">Add Students</a>
</div>
@endsection
