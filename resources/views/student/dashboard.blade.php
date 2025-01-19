@extends('layouts.app')

@section('content')
    @php
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
    @endphp

    <h1 class="tw-text-3xl tw-font-bold tw-mb-8 tw-text-gray-800">Selamat Datang di Dashboard Siswa</h1>

    <div class="tw-flex tw-flex-wrap lg:tw-flex-nowrap tw-min-w-full tw-justify-between tw-gap-8 tw-min-h-screen">
        <!-- Bagian Kiri -->
        <div class="tw-flex tw-flex-col tw-w-full lg:tw-w-2/3 tw-gap-8">
            <!-- Jadwal Hari Ini -->
            <div class="tw-bg-green-500 tw-p-6 tw-rounded-lg tw-shadow-lg">
                <h2 class="tw-text-white tw-font-semibold tw-text-lg">Jadwal Hari Ini</h2>
                <div class="tw-mt-4">
                    @if ($scheduleOfTheDay->isEmpty())
                        <p class="tw-text-white tw-text-sm">Tidak ada kelas yang dijadwalkan untuk hari ini.</p>
                    @else
                        <ul class="tw-text-white tw-text-sm">
                            @foreach ($scheduleOfTheDay as $course)
                                <li class="tw-mb-2">{{ $course->title }} - {{ $course->pivot->start_time }} sampai
                                    {{ $course->pivot->end_time }}</li>
                            @endforeach
                        </ul>
                    @endif
                    <button type="button" class="btn btn-light tw-mt-4" data-bs-toggle="modal"
                        data-bs-target="#weeklyScheduleModal">
                        Lihat Jadwal Mingguan
                    </button>
                </div>
            </div>

            <!-- Modal untuk Jadwal Mingguan -->
            <div class="modal fade" id="weeklyScheduleModal" tabindex="-1" aria-labelledby="weeklyScheduleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="weeklyScheduleModalLabel">Jadwal Mingguan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Hari</th>
                                        <th>Kelas</th>
                                        <th>Waktu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($days as $day)
                                        <tr>
                                            <td>{{ $day }}</td>
                                            <td>
                                                @php
                                                    $coursesForDay = $weekSchedule->filter(
                                                        fn($course) => $course->pivot->day === $day,
                                                    );
                                                @endphp
                                                @if ($coursesForDay->isEmpty())
                                                    <em>Tidak ada kelas</em>
                                                @else
                                                    <ul class="tw-list-disc tw-pl-4">
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

            <!-- Mata Pelajaran yang Baru Dibuka -->
            <div class="tw-bg-purple-500 tw-p-6 tw-rounded-lg tw-shadow-lg">
                <h2 class="tw-font-semibold tw-text-lg tw-text-white">Mata Pelajaran yang Baru Dibuka</h2>
                @if ($recentCourse)
                    <div class="tw-mt-4">
                        <h3 class="tw-text-white">{{ $recentCourse->title }}</h3>
                        <p class="tw-text-white tw-text-sm">{{ $recentCourse->description }}</p>
                        <a href="{{ route('student.courses.show', $recentCourse->id) }}" class="btn btn-light tw-mt-2">Ke
                            Mata Pelajaran</a>
                    </div>
                @else
                    <p class="tw-text-white tw-text-sm">Tidak ada Mata Pelajaran yang baru dibuka.</p>
                @endif
            </div>

            <!-- Semua Mata Pelajaran -->
            <div class="tw-bg-yellow-500 tw-p-6 tw-rounded-lg tw-shadow-lg">
                <h2 class="tw-font-semibold tw-text-lg">Mata Pelajaran</h2>
                <div class="tw-flex tw-flex-wrap tw-gap-6 tw-justify-center tw-mt-4">
                    @forelse ($allCourses as $course)
                        <a href="{{ route('student.courses.show', $course->id) }}" class="tw-no-underline">
                            <x-course_card :course-name="$course->title" :course-description="$course->description" :course-image="$course->image ?? 'images/course/default.jpeg'"/>
                        </a>
                    @empty
                        <p class="tw-text-gray-700">Tidak ada Mata Pelajaran yang tersedia.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Bagian Kanan -->
        <div class="tw-flex tw-flex-col tw-w-full lg:tw-w-1/3 tw-gap-8">
            <!-- Info Pribadi -->
            <div class="tw-bg-blue-500 tw-p-6 tw-rounded-lg tw-shadow-lg">
                <h2 class="tw-font-semibold tw-text-white tw-text-lg">Info Pribadi</h2>
                <div class="tw-flex tw-items-center tw-gap-6 tw-mt-4">
                    <img src="{{ "$student->profile_picture" ? asset($student->profile_picture) : 'https://via.placeholder.com/200x150' }}"
                        alt="Foto Profil" class="tw-w-24 tw-h-24 tw-object-cover tw-rounded-full">
                    <div class="tw-text-white">
                        <h3 class="tw-text-xl">{{ $student->name }}</h3>
                        <p class="tw-text-sm">NIK: {{ $student->nik }}</p>
                    </div>
                </div>

                @if ($classroom)
                    <div class="tw-mt-4">
                        <h3 class="tw-text-white tw-text-sm">Kelas: {{ $classroom->name }}</h3>
                        <a href="{{ route('student.ranking', $classroom->id) }}" class="btn btn-light">Lihat Peringkat
                            Kelas</a>
                    </div>
                @else
                    <p class="tw-text-white">Belum ada kelas yang ditugaskan.</p>
                @endif
            </div>

            <!-- Tenggat Waktu Terdekat -->
            <div class="tw-bg-red-500 tw-p-6 tw-rounded-lg tw-shadow-lg">
                <h2 class="tw-font-semibold tw-text-white tw-text-lg">Tenggat Waktu Terdekat</h2>
                @if ($deadlines->isEmpty())
                    <p class="tw-text-white tw-text-sm">Tidak ada tenggat waktu mendatang.</p>
                @else
                    <ul class="tw-text-white tw-mt-4">
                        @foreach ($deadlines as $deadline)
                            <li class="tw-mb-4">
                                <strong>{{ $deadline['type'] }}:</strong> {{ $deadline['title'] }}<br>
                                <span class="tw-text-sm">Batas Waktu:
                                    {{ \Carbon\Carbon::parse($deadline['deadline'])->format('Y-m-d H:i') }}</span><br>
                                <a href="{{ $deadline['link'] }}" class="btn btn-light btn-sm tw-mt-1">Lihat Detail</a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <!-- Balasan Terbaru -->
            <div class="tw-bg-indigo-500 tw-p-6 tw-rounded-lg tw-shadow-lg">
                <h2 class="tw-font-semibold tw-text-white tw-text-lg">Balasan Terbaru</h2>
                @if ($recentReplies->isEmpty())
                    <p class="tw-text-white tw-text-sm">Belum ada balasan terbaru.</p>
                @else
                    <ul class="tw-text-white tw-mt-4">
                        @foreach ($recentReplies as $reply)
                            <li class="tw-mb-6">
                                <p class="tw-font-medium">{{ $reply->user->name }} membalas:</p>
                                <p class="tw-italic tw-text-sm">"{{ Str::limit($reply->comment, 100) }}"</p>
                                <p class="tw-text-xs text-muted">{{ $reply->discussion->module->course->title }} | {{ $reply->discussion->module->title }} | {{ $reply->discussion->module->lessons->first()->title }}</p>
                                <a href="{{ route('discussions.show', $reply->discussion->id) }}"
                                    class="tw-text-yellow-300 hover:tw-underline">Lihat Diskusi</a>
                                <hr class="tw-my-2">
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
@endsection
