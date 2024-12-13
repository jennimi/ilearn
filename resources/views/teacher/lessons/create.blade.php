@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Add Lesson</h1>

        <form method="POST" action="{{ route('teacher.lessons.store', $module->id) }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="title" class="form-label">Lesson Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>

            <div class="mb-3">
                <label for="content" class="form-label">Upload PDF</label>
                <input type="file" class="form-control" id="content" name="content" accept="application/pdf" required>
            </div>

            <div class="mb-3">
                <label for="visible" class="form-label">Visible</label>
                <select class="form-control" id="visible" name="visible">
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Add Lesson</button>
        </form>
    </div>
@endsection
