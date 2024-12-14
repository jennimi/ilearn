@extends('layouts.app')

@section('content')
    @php
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    @endphp

    <h1>Welcome to the Student Dashboard</h1>

    <div class="tw-flex tw-flex-row tw-min-w-full tw-justify-between tw-gap-6 tw-min-h-screen tw-mt-8">
        <div class="tw-flex tw-flex-col tw-w-2/3 tw-gap-6">
            <!-- Schedule of the Day -->
            <div class="tw-flex tw-flex-col tw-bg-green-600 tw-min-h-8 tw-p-4 tw-rounded-lg">
                <h2 class="tw-text-white tw-font-bold">Schedule of the Day</h2>
                <div class="tw-flex tw-flex-col tw-mt-4">
                    @if ($scheduleOfTheDay->isEmpty())
                        <p class="tw-text-white">No classes scheduled for today.</p>
                    @else
                        <ul class="tw-text-white">
                            @foreach ($scheduleOfTheDay as $course)
                                <li>
                                    {{ $course->title }} - {{ $course->pivot->start_time }} to
                                    {{ $course->pivot->end_time }}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                    <button type="button" class="btn btn-light tw-mt-4" data-bs-toggle="modal"
                        data-bs-target="#weeklyScheduleModal">
                        View Week's Schedule
                    </button>
                </div>
            </div>

            <!-- Modal for Week's Schedule -->
            <!-- Modal for Weekly Schedule -->
            <div class="modal fade" id="weeklyScheduleModal" tabindex="-1" aria-labelledby="weeklyScheduleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="weeklyScheduleModalLabel">Weekly Schedule</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Day</th>
                                        <th>Course</th>
                                        <th>Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($days as $day)
                                        <tr>
                                            <td>{{ $day }}</td>
                                            <td>
                                                @php
                                                    $coursesForDay = $weekSchedule->filter(function ($course) use (
                                                        $day,
                                                    ) {
                                                        return $course->pivot->day === $day;
                                                    });
                                                @endphp

                                                @if ($coursesForDay->isEmpty())
                                                    <em>No classes</em>
                                                @else
                                                    <ul>
                                                        @foreach ($coursesForDay as $course)
                                                            <li>{{ $course->title }}</li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($coursesForDay->isEmpty())
                                                    --
                                                @else
                                                    <ul>
                                                        @foreach ($coursesForDay as $course)
                                                            <li>{{ $course->pivot->start_time }} -
                                                                {{ $course->pivot->end_time }}</li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="modal fade" id="weeklyScheduleModal" tabindex="-1" aria-labelledby="weeklyScheduleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="weeklyScheduleModalLabel">Weekly Schedule</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div id="weeklyCalendar"></div>
                        </div>
                    </div>
                </div>
            </div> --}}

            <!-- All Courses -->
            <div class="tw-flex tw-flex-col tw-bg-yellow-600 tw-p-4 tw-rounded-lg tw-min-h-8">
                <h2>Courses</h2>
                <div class="tw-flex tw-flex-wrap tw-items-center tw-justify-center tw-gap-8">
                    @forelse ($allCourses as $course)
                        <a href="{{ route('student.courses.show', $course->id) }}" class="tw-no-underline">
                            <x-course_card :course-name="$course->title" :course-description="$course->description" />
                        </a>
                    @empty
                        <p>No courses available.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Personal Info Section -->
        <div class="tw-flex tw-flex-col tw-grow-0 tw-w-1/3 tw-p-4 ">
            <div class="tw-bg-blue-600 tw-rounded-lg">
                <h2>Personal Info</h2>
                <div class="tw-flex tw-flex-row tw-gap-4 tw-grow mt-4">
                    <img src="{{ $student->profile_picture ? asset('storage/' . $student->profile_picture) : 'https://via.placeholder.com/200x150' }}"
                        alt="Profile Picture" class="tw-w-[1/2] tw-h-20 tw-object-cover">
                    <div>
                        <h3>{{ $student->name }}</h3>
                        <p>NIK: {{ $student->nik }}</p>
                    </div>
                </div>
            </div>

            <div class="tw-flex tw-flex-col tw-bg-indigo-600 tw-p-4 tw-rounded-lg">
                <h2 class="tw-text-white tw-font-bold">Recent Replies</h2>

                @if ($recentReplies->isEmpty())
                    <p class="tw-text-white">No recent replies yet.</p>
                @else
                    <ul class="tw-text-white tw-mt-4">
                        @foreach ($recentReplies as $reply)
                            <li class="tw-mb-4">
                                <p><strong>{{ $reply->user->name }}</strong> replied:</p>
                                <p class="tw-italic">"{{ Str::limit($reply->comment, 100) }}"</p>
                                <a href="{{ route('discussions.show', $reply->discussion->id) }}"
                                    class="tw-text-yellow-300 hover:tw-underline">
                                    View Discussion
                                </a>
                                <hr class="tw-my-2">
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
@endsection

{{-- @section('scripts')
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.8/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.8/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid@6.1.8/index.global.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log(@json($weekEvents));

            const calendarEl = document.getElementById('weeklyCalendar');

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridWeek',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'timeGridWeek,timeGridDay'
                },
                events: @json($weekEvents), // Use $weekEvents here
                nowIndicator: true,
                allDaySlot: false,
                slotMinTime: "06:00:00", // Customize start of schedule
                slotMaxTime: "22:00:00", // Customize end of schedule
            });
            calendar.render();
        });
    </script>
@endsection --}}
