@extends('layouts.app')

@section('content')
    <div class="tw-flex tw-flex-wrap lg:tw-flex-nowrap tw-min-w-full tw-justify-between tw-gap-8 tw-min-h-screen">
        <!-- Left Section -->
        <div class="tw-flex tw-flex-col tw-w-full lg:tw-w-2/3 tw-gap-8">
            <!-- Today's Schedule -->
            <div class="tw-bg-green-500 tw-p-6 tw-rounded-lg tw-shadow-lg">
                <h2 class="tw-text-white tw-font-semibold tw-text-lg">Schedule of ({{ now()->format('l') }})</h2>
                <div class="tw-mt-4">
                    @if ($todaySchedules->first()->classrooms->isEmpty())
                        <p class="tw-text-white tw-text-sm">No classes scheduled for today.</p>
                    @else
                        <ul class="tw-text-white tw-text-sm">
                            @foreach ($todaySchedules as $course)
                                <li class="tw-mb-2">{{ $course->title }} - {{ $course->pivot->start_time }} to
                                    {{ $course->pivot->end_time }}</li>
                            @endforeach
                        </ul>
                    @endif
                    <button type="button" class="btn btn-light tw-mt-4" data-bs-toggle="modal"
                        data-bs-target="#weeklyScheduleModal">
                        View Week's Schedule
                    </button>
                </div>
            </div>

            <!-- All Courses -->
            <div class="tw-bg-yellow-500 tw-p-6 tw-rounded-lg tw-shadow-lg">
                <h2 class="tw-font-semibold tw-text-lg">All Courses</h2>
                <div class="tw-flex tw-flex-wrap tw-gap-6 tw-justify-center tw-mt-4">
                    @foreach ($allCourses as $course)
                        <a href="{{ route('teacher.courses.show', $course->id) }}" class="tw-no-underline">
                            <x-course_card :course-name="$course->title" :course-description="$course->description" />
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Right Section -->
        <div class="tw-flex tw-flex-col tw-w-full lg:tw-w-1/3 tw-gap-8">
            <!-- Teacher Details -->
            <div class="tw-bg-blue-500 tw-p-6 tw-rounded-lg tw-shadow-lg">
                <h2 class="tw-font-semibold tw-text-white tw-text-lg">Teacher Info</h2>
                <div class="tw-flex tw-items-center tw-gap-6 tw-mt-4">
                    <img src="{{ $teacher->profile_picture ?? asset('images/placeholder-profile.png') }}"
                        alt="Profile Picture" class="tw-w-24 tw-h-24 tw-object-cover tw-rounded-full">
                    <div class="tw-text-white">
                        <h3 class="tw-text-xl">{{ $teacher->name }}</h3>
                        <p class="tw-text-sm">Teacher</p>
                    </div>
                </div>
            </div>

            <!-- Recent Course -->
            <div class="tw-bg-purple-500 tw-p-6 tw-rounded-lg tw-shadow-lg">
                <h2 class="tw-font-semibold tw-text-lg tw-text-white">Recent Course</h2>
                @if ($recentCourse)
                    <div class="tw-mt-4">
                        <h3 class="tw-text-white">{{ $recentCourse->title }}</h3>
                        <p class="tw-text-white tw-text-sm">{{ Str::limit($recentCourse->description, 100) }}</p>
                        <a href="{{ route('teacher.courses.show', $recentCourse->id) }}" class="btn btn-light tw-mt-2">Go to
                            Course</a>
                    </div>
                @else
                    <p class="tw-text-white tw-text-sm">No recent course available.</p>
                @endif
            </div>
        </div>


    </div>

@endsection
