@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <!-- Left Side -->
        <div class="col-md-4">
            <h1 class="mb-4 text-primary">{{ $course->title }}</h1>
            <p class="text-muted">{{ $course->description }}</p>
            <p><strong>Guru:</strong> {{ $course->teacher->name }}</p>

            <!-- Course Progress -->
            <div class="mb-4 text-center">
                <h4 class="text-secondary">Progres Anda</h4>
                <div class="progress" style="height: 30px; width: 100%; max-width: 300px; margin: 0 auto;">
                    <div id="progressBar" class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                        role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                        0%
                    </div>
                </div>
                <p class="mt-2"><strong id="progressPercentage">0%</strong> Selesai</p>
            </div>
        </div>

        <!-- Right Side -->
        <div class="col-md-8">
            <!-- Modules and Lessons Section -->
            <div class="accordion" id="modulesAccordion">
                <h3 class="text-secondary">Modul</h3>
                @foreach ($course->modules as $module)
                    <div class="accordion-item mb-3 shadow-sm border">
                        <h2 class="accordion-header" id="heading{{ $module->id }}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse{{ $module->id }}" aria-expanded="false"
                                aria-controls="collapse{{ $module->id }}">
                                <span class="fw-bold">{{ $module->title }}</span>
                                <span class="text-muted ms-2">{{ $module->description }}</span>
                            </button>
                        </h2>
                        <div id="collapse{{ $module->id }}" class="accordion-collapse collapse"
                            aria-labelledby="heading{{ $module->id }}" data-bs-parent="#modulesAccordion">
                            <div class="accordion-body">

                                <!-- Lessons Section -->
                                <h5 class="text-secondary">Pelajaran</h5>
                                @if ($module->lessons->isEmpty())
                                    <p class="text-danger">Tidak ada pelajaran untuk modul ini.</p>
                                @else
                                    <ul class="list-group mb-4">
                                        @foreach ($module->lessons as $lesson)
                                            @if ($lesson->visible)
                                                <li class="list-group-item">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <strong>{{ $lesson->title }}</strong>
                                                            <div>
                                                                <span
                                                                    class="badge bg-{{ $lesson->visible ? 'success' : 'danger' }}">
                                                                    {{ $lesson->visible ? 'Terlihat' : 'Tersembunyi' }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <a href="{{ asset('storage/' . $lesson->content) }}"
                                                                target="_blank" class="btn btn-success btn-sm">
                                                                Lihat PDF Lengkap
                                                            </a>
                                                        </div>
                                                    </div>

                                                    <!-- Inline PDF Preview -->
                                                    <div class="mt-3">
                                                        <div class="card shadow-sm">
                                                            <div class="card-body text-center">
                                                                <iframe
                                                                    src="{{ asset('storage/' . $lesson->content) }}#toolbar=0&navpanes=0&scrollbar=0"
                                                                    width="50%" height="200px" class="border rounded">
                                                                </iframe>
                                                                <div class="mt-3">
                                                                    <a href="{{ asset('storage/' . $lesson->content) }}"
                                                                        target="_blank" class="btn btn-primary btn-sm">
                                                                        Buka Tampilan Penuh
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                @endif


                                <!-- Quizzes Section -->
                                <h5 class="text-secondary">Kuis</h5>
                                @if ($module->quizzes->isEmpty())
                                    <p class="text-danger">Tidak ada kuis untuk modul ini.</p>
                                @else
                                    <ul class="list-group mb-4">
                                        @foreach ($module->quizzes as $quiz)
                                            @if ($quiz->visible)
                                                <li class="list-group-item">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <strong>{{ $quiz->title }}</strong>
                                                            <p class="text-muted">{{ $quiz->description }}</p>
                                                        </div>
                                                        <a href="{{ route('student.quizzes.take', $quiz->id) }}"
                                                            class="btn btn-outline-success btn-sm">
                                                            Ambil Kuis
                                                        </a>
                                                    </div>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                @endif

                                <!-- Assignments Section -->
                                <h5 class="text-secondary">Tugas</h5>
                                @if ($module->assignments->isEmpty())
                                    <p class="text-danger">Tidak ada tugas untuk modul ini.</p>
                                @else
                                    <ul class="list-group mb-4">
                                        @foreach ($module->assignments as $assignment)
                                            @if ($assignment->visible)
                                                <li class="list-group-item">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <strong>{{ $assignment->title }}</strong>
                                                            <p class="text-muted">{{ $assignment->description }}</p>
                                                            <p class="text-muted">
                                                                Batas Waktu:
                                                                <span
                                                                    class="{{ now()->greaterThan($assignment->deadline) ? 'text-danger' : 'text-success' }}">
                                                                    {{ $assignment->deadline->format('Y-m-d H:i') }}
                                                                </span>
                                                            </p>
                                                        </div>
                                                        <a href="{{ route('student.assignments.show', $assignment->id) }}"
                                                            class="btn btn-outline-primary btn-sm">
                                                            Lihat Tugas
                                                        </a>
                                                    </div>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                @endif


                                <!-- Link to Discussion -->
                                @if ($module->discussion)
                                    <div class="mt-4 text-end">
                                        <a href="{{ route('discussions.show', $module->discussion->id) }}"
                                            class="btn btn-outline-primary">
                                            <i class="bi bi-chat-text"></i> Pergi ke Diskusi
                                        </a>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Fetch total and completed tasks from Blade variables
        const totalTasks = @json($totalQuizzes + $totalAssignments);
        const completedTasks = @json($completedQuizzes + $gradedAssignments);

        // Calculate progress percentage
        const progressPercentage = totalTasks > 0 ? Math.round((completedTasks / totalTasks) * 100) : 0;

        // Update progress bar width and text
        const progressBar = document.getElementById('progressBar');
        const progressText = document.getElementById('progressPercentage');

        progressBar.style.width = `${progressPercentage}%`;
        progressBar.setAttribute('aria-valuenow', progressPercentage);
        progressBar.textContent = `${progressPercentage}%`;

        // Update progress percentage text
        progressText.textContent = `${progressPercentage}%`;
    });
</script>
