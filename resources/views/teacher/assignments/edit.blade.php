@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Tugas</h1>

        <form method="POST" action="{{ route('teacher.assignments.update', $assignment->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="title" class="form-label">Judul</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ $assignment->title }}" required>
            </div>

            <div class="mb-4">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="description" name="description" rows="4">{{ $assignment->description }}</textarea>
            </div>

            <div class="mb-4">
                <label for="deadline" class="form-label">Batas Waktu</label>
                <input type="datetime-local" class="form-control" id="deadline" name="deadline"
                    value="{{ $assignment->deadline->format('Y-m-d\TH:i') }}" required>
            </div>

            <div class="mb-4">
                <label for="visible" class="form-label">Visibilitas</label>
                <select class="form-select" id="visible" name="visible" required>
                    <option value="1" {{ $assignment->visible ? 'selected' : '' }}>Terlihat</option>
                    <option value="0" {{ !$assignment->visible ? 'selected' : '' }}>Tersembunyi</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Perbarui Tugas</button>
            <a href="{{ route('teacher.assignments.show', $assignment->id) }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection
