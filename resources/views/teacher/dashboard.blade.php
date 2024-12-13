@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <!-- Today's Schedule -->
        <div class="col-md-8">
            <h3>Today's Schedule ({{ now()->format('l') }})</h3>
            @if ($todaySchedules->isEmpty())
                <p>No classes scheduled for today.</p>
            @else
                <ul class="list-group">
                    @foreach ($todaySchedules as $course)
                        @foreach ($course->classrooms as $classroom)
                            <li class="list-group-item">
                                <strong>{{ $classroom->name }}</strong><br>
                                {{ $classroom->pivot->start_time }} - {{ $classroom->pivot->end_time }}<br>
                                Course: {{ $course->title }}
                            </li>
                        @endforeach
                    @endforeach
                </ul>
            @endif
        </div>

        <!-- Teacher Details -->
        <div class="col-md-4">
            <h3>Teacher Details</h3>
            <div class="card">
                <div class="card-body text-center">
                    <img src="{{ $teacher->profile_picture }}" alt="Profile Picture" class="rounded-circle" width="100" height="100">
                    <h5 class="card-title mt-2">{{ $teacher->name }}</h5>
                </div>
            </div>
        </div>
    </div>

    <!-- All Courses -->
    <div class="mt-5">
        <h3>All Courses</h3>
        @if ($allCourses->isEmpty())
            <p>No courses available.</p>
        @else
            <div class="row">
                @foreach ($allCourses as $course)
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ $course->title }}</h5>
                                <p>{{ Str::limit($course->description, 100) }}</p>
                                <a href="{{ route('teacher.courses.show', $course->id) }}" class="btn btn-primary btn-sm">View Course</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
