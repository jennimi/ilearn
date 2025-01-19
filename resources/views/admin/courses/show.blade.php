@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detail Kursus: {{ $course->title }}</h1>

    <p><strong>Guru:</strong> {{ $course->teacher->name }}</p>
    <p><strong>Deskripsi:</strong> {{ $course->description }}</p>
    <p><strong>Tanggal Mulai:</strong> {{ $course->start_date }}</p>
    <p><strong>Tanggal Selesai:</strong> {{ $course->end_date }}</p>

    <h3>Kelas</h3>
    @foreach ($course->classrooms as $classroom)
        <p>
            {{ $classroom->name }}<br>
            <p>
                {{ $classroom->pivot->day }}:
                {{ $classroom->pivot->start_time }} - {{ $classroom->pivot->end_time }}
            </p>
        </p>
    @endforeach

    <a href="{{ route('admin.courses.edit', $course->id) }}" class="btn btn-warning">Edit Kursus</a>
    <form action="{{ route('admin.courses.destroy', $course->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Hapus Kursus</button>
    </form>
</div>
@endsection
