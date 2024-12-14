@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <!-- Today's Schedule -->
            <div class="col-md-8 mb-4 d-flex align-items-stretch">
                <div class="card w-100">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title mb-0">Today's Schedule ({{ now()->format('l') }})</h3>
                    </div>
                    <div class="card-body">
                        @if ($todaySchedules->first()->classrooms->isEmpty())
                            <div class="text-center">
                                <p class="text-muted">No classes scheduled for today</p>
                            </div>
                        @else
                            <div class="d-flex gap-3 overflow-auto schedule-scroll-horizontal">
                                @foreach ($todaySchedules as $course)
                                    @foreach ($course->classrooms as $classroom)
                                        <div class="card flex-shrink-0" style="min-width: 250px;">
                                            <div class="card-body">
                                                <h5 class="card-title text-primary">{{ $classroom->name }}</h5>
                                                <p class="text-muted mb-1">
                                                    <small>{{ $classroom->pivot->start_time }} -
                                                        {{ $classroom->pivot->end_time }}</small>
                                                </p>
                                                <p class="mb-0">Course: <strong>{{ $course->title }}</strong></p>
                                            </div>
                                        </div>
                                    @endforeach
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Teacher Details -->
            <div class="col-md-4 mb-4 d-flex align-items-stretch">
                <div class="card w-100 text-center">
                    <div class="card-body">
                        <img src="{{ $teacher->profile_picture ?? asset('images/placeholder-profile.png') }}"
                            alt="Profile Picture" class="rounded-circle border mb-3" width="100" height="100">
                        <h5 class="card-title">{{ $teacher->name }}</h5>
                        <p class="text-muted mb-0">Teacher</p>
                    </div>
                </div>
            </div>
        </div>


        <div class="mb-4">
            <h3>Recent Course</h3>
            @if ($recentCourse)
                <div class="d-flex justify-content-center">
                    <div class="col-md-4 mb-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title text-primary">{{ $recentCourse->title }}</h5>
                                <p class="text-muted">{{ Str::limit($recentCourse->description, 100) }}</p>
                                <a href="{{ route('teacher.courses.show', $recentCourse->id) }}"
                                    class="btn btn-primary btn-sm">View Course</a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <p class="text-muted">No recent course available.</p>
            @endif
        </div>

        <!-- All Courses -->
        <div class="">
            <h3 class="mb-4">All Courses</h3>
            @if ($allCourses->isEmpty())
                <p class="text-muted">No courses available.</p>
            @else
                <div class="row">
                    @foreach ($allCourses as $course)
                        <div class="col-md-4 mb-3">
                            <div class="card h-100">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title text-primary">{{ $course->title }}</h5>
                                    <p class="text-muted">{{ Str::limit($course->description, 100) }}</p>
                                    <div class="mt-auto">
                                        <a href="{{ route('teacher.courses.show', $course->id) }}"
                                            class="btn btn-primary btn-sm w-100">View Course</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
