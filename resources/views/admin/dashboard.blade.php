@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>User Management</h3>
            <div>
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary me-2">Create User</a>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">See All Users</a>
            </div>
        </div>
        <!-- Metrics Section -->
        <div class="row text-center">
            <div class="col-md-4">
                <div class="card bg-light p-3">
                    <h5>Enrolled</h5>
                    <h1 class="text-primary">19</h1>
                    <p>Students</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-light p-3">
                    <h5>Enrolled</h5>
                    <h1 class="text-success">22</h1>
                    <p>Teachers</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-light p-3">
                    <h5>Classrooms</h5>
                    <h1 class="text-warning">0</h1>
                    <p>Rooms</p>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="row mt-4">
            <!-- Notice Board -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5>List of Classrooms</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <a href="{{ route('admin.classrooms.create') }}" class="btn btn-primary me-2">Create
                                Classroom</a>
                            <a href="{{ route('admin.classrooms.index') }}" class="btn btn-secondary">More Classrooms</a>
                        </div>
                        @foreach ($classrooms as $classroom)
                            <div class="card mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $classroom->name }}</h5>
                                        <p class="card-text">Time Period: {{ $classroom->time_period }}</p>
                                        <p class="card-text">Homeroom Teacher: {{ $classroom->teacher->name }}</p>
                                        <a href="{{ route('admin.classrooms.show', $classroom->id) }}"
                                            class="btn btn-primary">View
                                            Classroom</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        @if ($classrooms->isEmpty())
                            <div class="text-center">
                                <p>No classrooms have been created</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Birthdays -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5>List of Courses</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <a href="{{ route('admin.courses.create') }}" class="btn btn-primary me-2">Create Course</a>
                            <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">More Courses</a>
                        </div>
                        @foreach ($courses as $course)
                            <div class="card mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $course->title }}</h5>
                                        <p class="card-text">{{ $course->description }}</p>
                                        <p class="card-text">Teacher: {{ $course->teacher->name }}</p>
                                        <p class="card-text">Schedule : {{ $course->classrooms->first()->pivot->day }}
                                            {{ $course->classrooms->first()->pivot->start_time }}-{{ $course->classrooms->first()->pivot->end_time }}
                                        </p>
                                        <p class="card-text">Start Date: {{ $course->start_date }} | End Date:
                                            {{ $course->end_date }}</p>
                                        <a href="{{ route('admin.courses.show', $course->id) }}"
                                            class="btn btn-primary">View
                                            course</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @if ($courses->isEmpty())
                            <div class="text-center">
                                <p>No courses have been created</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endsection
