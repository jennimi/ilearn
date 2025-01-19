@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Kelas</h1>
            @if (!$classrooms->isEmpty())
                <div>
                    <a href="{{ route('admin.classrooms.create') }}" class="btn btn-primary me-2">Buat Kelas</a>
                </div>
            @endif
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($classrooms->isEmpty())
            <p>Tidak ada kursus yang tersedia. <a href="{{ route('admin.courses.create') }}">Buat Kursus</a></p>
        @else
            <div class="row">
                @foreach ($classrooms as $classroom)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">{{ $classroom->name }}</h5>
                                <p class="card-text">Periode Waktu: {{ $classroom->time_period }}</p>
                                <p class="card-text">Wali Kelas: {{ $classroom->teacher->name }}</p>
                                <a href="{{ route('admin.classrooms.show', $classroom->id) }}" class="btn btn-primary">Lihat
                                    Kelas</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
