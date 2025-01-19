@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>Manajemen Pengguna</h3>
            <div>
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary me-2">Buat Pengguna</a>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Lihat Semua Pengguna</a>
            </div>
        </div>
        <!-- Metrics Section -->
        <div class="row text-center">
            <div class="col-md-4">
                <div class="card bg-light p-3">
                    <h5>Terdaftar</h5>
                    <h1 class="text-primary">{{ $students }}</h1>
                    <p>Siswa</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-light p-3">
                    <h5>Terdaftar</h5>
                    <h1 class="text-success">{{ $teachers }}</h1>
                    <p>Guru</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-light p-3">
                    <h5>Kelas</h5>
                    <h1 class="text-warning">{{ $classroomsCount }}</h1>
                    <p>Ruang</p>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="row mt-4">
            <!-- Notice Board -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Daftar Kelas</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <a href="{{ route('admin.classrooms.create') }}" class="btn btn-primary me-2">Buat Kelas</a>
                            <a href="{{ route('admin.classrooms.index') }}" class="btn btn-secondary">Lihat Lebih Banyak</a>
                        </div>
                        @foreach ($classrooms as $classroom)
                            <div class="card mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $classroom->name }}</h5>
                                        <p class="card-text">Periode Waktu: {{ $classroom->time_period }}</p>
                                        <p class="card-text">Wali Kelas: {{ $classroom->teacher->name }}</p>
                                        <a href="{{ route('admin.classrooms.show', $classroom->id) }}"
                                            class="btn btn-primary">Lihat Kelas</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        @if ($classrooms->isEmpty())
                            <div class="text-center">
                                <p>Belum ada kelas yang dibuat</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Birthdays -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Daftar Kursus</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <a href="{{ route('admin.courses.create') }}" class="btn btn-primary me-2">Buat Kursus</a>
                            <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">Lihat Lebih Banyak</a>
                        </div>
                        @foreach ($courses as $course)
                            <div class="card mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $course->title }}</h5>
                                        <p class="card-text">{{ $course->description }}</p>
                                        <p class="card-text">Guru: {{ $course->teacher->name }}</p>
                                        <p class="card-text">Jadwal : {{ $course->classrooms->first()->pivot->day }}
                                            {{ $course->classrooms->first()->pivot->start_time }}-{{ $course->classrooms->first()->pivot->end_time }}
                                        </p>
                                        <p class="card-text">Tanggal Mulai: {{ $course->start_date }} | Tanggal Selesai:
                                            {{ $course->end_date }}</p>
                                        <a href="{{ route('admin.courses.show', $course->id) }}"
                                            class="btn btn-primary">Lihat Kursus</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @if ($courses->isEmpty())
                            <div class="text-center">
                                <p>Belum ada kursus yang dibuat</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endsection
