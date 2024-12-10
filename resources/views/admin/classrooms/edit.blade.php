@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Classroom: {{ $classroom->name }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.classrooms.update', $classroom->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Classroom Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $classroom->name }}" required>
        </div>

        <div class="mb-3">
            <label for="time_period" class="form-label">Time Period</label>
            <input type="text" class="form-control" id="time_period" name="time_period" value="{{ $classroom->time_period }}" required>
        </div>

        <div class="mb-3">
            <label for="teacher_id" class="form-label">Homeroom Teacher</label>
            <select class="form-control" id="teacher_id" name="teacher_id" required>
                @foreach ($teachers as $teacher)
                    <option value="{{ $teacher->id }}" {{ $teacher->id == $classroom->teacher_id ? 'selected' : '' }}>
                        {{ $teacher->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Classroom</button>
    </form>
</div>
@endsection
