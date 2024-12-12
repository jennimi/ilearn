@extends('layouts.app')

@section('content')
    <style>
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
            /* For Chrome, Safari, and Opera */
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            /* For Internet Explorer and Edge */
            scrollbar-width: none;
            /* For Firefox */
        }
    </style>

    @php
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    @endphp

    <h1>Welcome to the Student Dashboard</h1>

    <div class="tw-flex tw-flex-row tw-min-w-full tw-justify-between tw-gap-6 tw-min-h-screen tw-mt-8">
        <div class="tw-flex tw-flex-col tw-w-2/3 tw-gap-6">
            <div class="tw-flex tw-flex-col tw-bg-green-600 tw-min-h-8 tw-p-4 tw-rounded-lg">
                <h2 class="tw-text-white tw-font-bold">Schedule of the Day</h2>
                <div class="tw-flex tw-flex-row tw-gap-4 tw-mt-4 tw-overflow-x-auto scrollbar-hide tw-h-48">
                    @foreach ($days as $day)
                        <x-schedule_course_card :course-name="$day" />
                    @endforeach
                </div>
            </div>
            <div class="tw-flex tw-flex-col tw-bg-yellow-600 tw-p-4 tw-rounded-lg tw-min-h-8">
                <h2>Courses</h2>
                <div class="tw-flex tw-flex-wrap tw-items-center tw-justify-center tw-gap-8">
                    @foreach ($days as $day)
                        <x-course_card :course-name="$day" />
                    @endforeach
                </div>
            </div>
        </div>
        <div class="tw-flex tw-flex-col tw-bg-blue-600 tw-grow-0 tw-w-1/3 tw-p-4 tw-rounded-lg">
            <h2>Personal Info</h2>

            <div class="tw-flex tw-flex-row tw-gap-4 tw-grow mt-4">
                <img src="https://via.placeholder.com/200x150" alt="image" class="tw-w-[1/2] tw-h-20 tw-object-cover">
                <div>
                    <h3>Student Name</h3>
                    <p>NIK: xxx1</p>
                </div>
            </div>

            d
        </div>
    </div>
@endsection
