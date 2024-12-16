@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <!-- Left Column -->
            <div class="col-lg-8 mb-4">
                <!-- Today's Schedule -->
                <div class="card mb-4 shadow-sm border">
                    <div class="card-header bg-light">
                        <h3 class="card-title mb-0 text-dark">Today's Schedule ({{ now()->format('l') }})</h3>
                    </div>
                    <div class="card-body">
                        @if ($todaySchedules->isEmpty() || $todaySchedules->first()->classrooms->isEmpty())
                            <div class="text-center">
                                <p class="text-muted">No classes scheduled for today</p>
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
                                                <p class="mb-0">Course: <strong>{{ $course->title }}</strong></p>
                                            </div>
                                        </div>
                                    @endforeach
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Recent Course -->
                <div class="card shadow-sm border">
                    <div class="card-body">
                        <h3 class="text-dark">Recent Course</h3>
                        @if ($recentCourse)
                            <h5 class="card-title">{{ $recentCourse->title }}</h5>
                            <p class="text-muted">{{ Str::limit($recentCourse->description, 100) }}</p>
                            <a href="{{ route('teacher.courses.show', $recentCourse->id) }}"
                                class="btn btn-outline-dark btn-sm">View Course</a>
                        @else
                            <p class="text-muted">No recent course available.</p>
                        @endif
                    </div>
                </div>


                <!-- All Courses -->
                <div class="mb-4 mt-4">
                    <h3 class="text-dark">All Courses</h3>
                    @if ($allCourses->isEmpty())
                        <p class="text-muted">No courses available.</p>
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
                                                alt="Course Image" class="w-100 h-100 object-cover">
                                        </div>
                                        <div class="p-3 bg-light">
                                            <p class="text-muted">{{ Str::limit($course->description, 100) }}</p>
                                            <a href="{{ route('teacher.courses.show', $course->id) }}"
                                                class="btn btn-outline-dark btn-sm w-100 mt-3">View Course</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-lg-4 mb-4">
                <!-- Teacher Details -->
                <div class="card shadow-sm border mb-4 text-center">
                    <div class="card-body">
                        <img src="{{ $teacher->profile_picture ?? asset('images/placeholder-profile.png') }}"
                            alt="Profile Picture" class="rounded-circle border mb-3" width="100" height="100">
                        <h5 class="card-title text-dark">{{ $teacher->name }}</h5>
                        <p class="text-muted mb-0">Teacher</p>
                    </div>
                </div>

                <!-- Recent Comments -->
                <div class="card shadow-sm border">
                    <div class="card-body">
                        <h3 class="text-dark">Recent Comments</h3>
                        @if ($recentComments->isEmpty())
                            <p class="text-muted">No comments available.</p>
                        @else
                            <ul class="list-group">
                                @foreach ($recentComments as $comment)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="mb-1">
                                                <strong>{{ $comment->user->student->name ?? 'Unknown Student' }}</strong>
                                                commented on <strong>{{ $comment->discussion->title }}</strong>:
                                            </p>
                                            <p class="text-muted mb-0">{{ Str::limit($comment->comment, 100) }}</p>
                                        </div>
                                        <a href="{{ route('discussions.show', $comment->discussion_id) }}"
                                            class="btn btn-outline-dark btn-sm">View Discussion</a>
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
