@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Classroom</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.classrooms.store') }}">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Classroom Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <div class="mb-3">
            <label for="time_period" class="form-label">Time Period</label>
            <select class="form-control" id="time_period" name="time_period" required>
                @for ($year = date('Y') - 2; $year <= date('Y') + 2; $year++)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endfor
            </select>
        </div>

        <div class="mb-3">
            <label for="teacher_id" class="form-label">Homeroom Teacher</label>
            <select class="form-control" id="teacher_id" name="teacher_id" required>
                <option value="">-- Select Teacher --</option>
                @foreach ($teachers as $teacher)
                    <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Create Classroom</button>
    </form>
</div>
@endsection
