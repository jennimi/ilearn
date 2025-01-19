@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <!-- Kolom Kiri -->
            <div class="col-lg-8 mb-4">
                <!-- Jadwal Hari Ini -->
                <div class="card mb-4 shadow-sm border">
                    <div class="card-header bg-light">
                        <h3 class="card-title mb-0 text-dark">Jadwal Hari Ini ({{ now()->format('l') }})</h3>
                    </div>
                    <div class="card-body">
                        @if ($todaySchedules->isEmpty() || $todaySchedules->first()->classrooms->isEmpty())
                            <div class="text-center">
                                <p class="text-muted">Tidak ada kelas yang dijadwalkan hari ini</p>
                            </div>
                        @else
                            <div class="d-flex gap-3 overflow-auto schedule-scroll-horizontal">
                                @foreach ($todaySchedules as $course)
                                    @foreach ($course->classrooms as $classroom)
                                        <div class="card flex-shrink-0 border shadow-sm" style="min-width: 250px;">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $classroom->name }}</h5>
                                                <p class="text-muted mb-1">
                                                    <small>{{ $classroom->pivot->start_time }} -
                                                        {{ $classroom->pivot->end_time }}</small>
                                                </p>
                                                <p class="mb-0">Mata Pelajaran: <strong>{{ $course->title }}</strong></p>
                                            </div>
                                        </div>
                                    @endforeach
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Mata Pelajaran Terbaru -->
                <div class="card shadow-sm border">
                    <div class="card-body">
                        <h3 class="text-dark">Mata Pelajaran Terbaru</h3>
                        @if ($recentCourse)
                            <h5 class="card-title">{{ $recentCourse->title }}</h5>
                            <p class="text-muted">{{ Str::limit($recentCourse->description, 100) }}</p>
                            <a href="{{ route('teacher.courses.show', $recentCourse->id) }}"
                                class="btn btn-outline-dark btn-sm">Lihat Mata Pelajaran</a>
                        @else
                            <p class="text-muted">Tidak ada Mata Pelajaran terbaru.</p>
                        @endif
                    </div>
                </div>


                <!-- Semua Mata Pelajaran -->
                <div class="mb-4 mt-4">
                    <h3 class="text-dark">Semua Mata Pelajaran</h3>
                    @if ($allCourses->isEmpty())
                        <p class="text-muted">Tidak ada Mata Pelajaran yang tersedia.</p>
                    @else
                        <div class="row">
                            @foreach ($allCourses as $course)
                                <div class="col-md-4 mb-3">
                                    <div
                                        class="bg-white rounded-lg shadow-sm border tw-flex tw-flex-col overflow-hidden h-80 w-full">
                                        <div class="p-3 bg-light">
                                            <h5 class="text-dark">{{ $course->title }}</h5>
                                        </div>
                                        <div
                                            class="flex-grow d-flex justify-content-center align-items-center overflow-hidden">
                                            <img src="{{ asset($course->image ?? 'images/default-course-image.jpg') }}"
                                                alt="Gambar Mata Pelajaran" class="w-100 h-100 object-cover">
                                        </div>
                                        <div class="p-3 bg-light">
                                            <p class="text-muted">{{ Str::limit($course->description, 100) }}</p>
                                            <a href="{{ route('teacher.courses.show', $course->id) }}"
                                                class="btn btn-outline-dark btn-sm w-100 mt-3">Lihat Mata Pelajaran</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Kolom Kanan -->
            <div class="col-lg-4 mb-4">
                <!-- Detail Guru -->
                <div class="card shadow-sm border mb-4 text-center">
                    <div class="card-body">
                        <img src="{{ $teacher->profile_picture ?? asset('images/placeholder-profile.png') }}"
                            alt="Foto Profil" class="rounded-circle border mb-3" width="100" height="100">
                        <h5 class="card-title text-dark">{{ $teacher->name }}</h5>
                        <p class="text-muted mb-0">Guru</p>
                    </div>
                </div>

                <!-- Komentar Terbaru -->
                <div class="card shadow-sm border">
                    <div class="card-body">
                        <h3 class="text-dark">Komentar Terbaru</h3>
                        @if ($recentComments->isEmpty())
                            <p class="text-muted">Tidak ada komentar yang tersedia.</p>
                        @else
                            <ul class="list-group">
                                @foreach ($recentComments as $comment)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="mb-1">
                                                <strong>{{ $comment->user->student->name ?? 'Siswa Tidak Diketahui' }}</strong>
                                                mengomentari <strong>{{ $comment->discussion->title }}</strong>:
                                            </p>
                                            <p class="text-muted mb-0">{{ Str::limit($comment->comment, 100) }}</p>
                                        </div>
                                        <a href="{{ route('discussions.show', $comment->discussion_id) }}"
                                            class="btn btn-outline-dark btn-sm">Lihat Diskusi</a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
