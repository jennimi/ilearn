@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-2 text-primary">{{ $course->title }}</h1>
        <p class="text-muted mb-3">{{ $course->description }}</p>

        <div class="mb-3">
            <h3 class="text-secondary">Kelas</h3>
            <div class="row">
                @foreach ($course->classrooms as $classroom)
                    <div class="col-lg-2 col-md-3 col-sm-4 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-body text-center">
                                <h5 class="card-title">{{ $classroom->name }}</h5>
                                <p class="text-muted small">{{ $classroom->pivot->day }}</p>
                                <p class="text-muted small">
                                    {{ $classroom->pivot->start_time }} - {{ $classroom->pivot->end_time }}
                                </p>
                                <a href="{{ route('teacher.leaderboard', $classroom->id) }}" class="btn btn-primary btn-sm">
                                    Lihat Peringkat
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Bagian Modul dan Pelajaran -->
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

                            <!-- Bagian Pelajaran -->
                            <h5 class="text-secondary">Pelajaran</h5>
                            @if ($module->lessons->isEmpty())
                                <p class="text-danger">Tidak ada pelajaran untuk modul ini.</p>
                            @else
                                <ul class="list-group mb-4">
                                    @foreach ($module->lessons as $lesson)
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
                                                    <a href="{{ asset('storage/' . $lesson->content) }}" target="_blank"
                                                        class="btn btn-success btn-sm">
                                                        Lihat PDF Lengkap
                                                    </a>
                                                    <button type="button" class="btn btn-outline-primary btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editLessonModal{{ $lesson->id }}">
                                                        Edit
                                                    </button>
                                                    <button type="button" class="btn btn-outline-secondary btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#toggleVisibilityModal{{ $lesson->id }}">
                                                        Perbarui Visibilitas
                                                    </button>
                                                    <button type="button" class="btn btn-outline-danger btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteLessonModal{{ $lesson->id }}">
                                                        Hapus
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="mt-3">
                                                <div class="card shadow-sm">
                                                    <div class="card-body text-center">
                                                        <iframe
                                                            src="{{ asset('storage/' . $lesson->content) }}#toolbar=0&navpanes=0&scrollbar=0&zoom=50"
                                                            width="50%" height="200px" class="border rounded"></iframe>
                                                        <div class="mt-3">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal fade" id="editLessonModal{{ $lesson->id }}" tabindex="-1"
                                                aria-labelledby="editLessonModalLabel{{ $lesson->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <form method="POST"
                                                        action="{{ route('teacher.lessons.update', $lesson->id) }}"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="editLessonModalLabel{{ $lesson->id }}">Edit
                                                                    Pelajaran</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Tutup"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="editTitle{{ $lesson->id }}"
                                                                        class="form-label">Judul Pelajaran</label>
                                                                    <input type="text" class="form-control"
                                                                        id="editTitle{{ $lesson->id }}" name="title"
                                                                        value="{{ $lesson->title }}" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="editContent{{ $lesson->id }}"
                                                                        class="form-label">Ganti PDF (Opsional)</label>
                                                                    <input type="file" class="form-control"
                                                                        id="editContent{{ $lesson->id }}" name="content"
                                                                        accept="application/pdf">
                                                                    <small class="text-muted">Kosongkan jika ingin
                                                                        menggunakan file saat ini.</small>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="editVisible{{ $lesson->id }}"
                                                                        class="form-label">Terlihat</label>
                                                                    <select class="form-control"
                                                                        id="editVisible{{ $lesson->id }}"
                                                                        name="visible">
                                                                        <option value="1"
                                                                            {{ $lesson->visible ? 'selected' : '' }}>Ya
                                                                        </option>
                                                                        <option value="0"
                                                                            {{ !$lesson->visible ? 'selected' : '' }}>Tidak
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit" class="btn btn-primary">Simpan
                                                                    Perubahan</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                            <div class="modal fade" id="deleteLessonModal{{ $lesson->id }}"
                                                tabindex="-1"
                                                aria-labelledby="deleteLessonModalLabel{{ $lesson->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <form method="POST"
                                                        action="{{ route('teacher.lessons.destroy', $lesson->id) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="deleteLessonModalLabel{{ $lesson->id }}">Hapus
                                                                    Pelajaran</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Tutup"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Apakah Anda yakin ingin menghapus pelajaran
                                                                <strong>{{ $lesson->title }}</strong>? Tindakan ini
                                                                tidak dapat dibatalkan.
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit"
                                                                    class="btn btn-danger">Hapus</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                            <!-- Modal Perbarui Visibilitas -->
                                            <div class="modal fade" id="toggleVisibilityModal{{ $lesson->id }}"
                                                tabindex="-1"
                                                aria-labelledby="toggleVisibilityModalLabel{{ $lesson->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <form method="POST"
                                                        action="{{ route('teacher.lessons.update', $lesson->id) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="toggleVisibilityModalLabel{{ $lesson->id }}">
                                                                    Perbarui Visibilitas Pelajaran
                                                                </h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Tutup"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Apakah Anda yakin ingin
                                                                <strong>{{ $lesson->visible ? 'menyembunyikan' : 'menampilkan' }}</strong>
                                                                pelajaran ini kepada siswa?
                                                            </div>
                                                            <input type="hidden" name="visible"
                                                                value="{{ $lesson->visible ? 0 : 1 }}">
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit"
                                                                    class="btn btn-primary">Konfirmasi</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                            <div class="d-flex justify-content-end mb-3">
                                <button class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addLessonModal{{ $module->id }}">
                                    <i class="bi bi-plus-circle"></i> Tambah Pelajaran
                                </button>
                            </div>

                            <!-- Bagian Kuis -->
                            <h5 class="text-secondary mt-4">Kuis</h5>
                            @if ($module->quizzes->isEmpty())
                                <p class="text-danger">Tidak ada kuis untuk modul ini.</p>
                            @else
                                <ul class="list-group mb-4">
                                    @foreach ($module->quizzes as $quiz)
                                        <li class="list-group-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <strong>{{ $quiz->title }}</strong>
                                                    <span
                                                        class="badge bg-{{ $quiz->visible ? 'success' : 'danger' }} ms-2">
                                                        {{ $quiz->visible ? 'Terlihat' : 'Tersembunyi' }}
                                                    </span>
                                                </div>
                                                <div>
                                                    <a href="{{ route('teacher.quizzes.show', $quiz->id) }}"
                                                        class="btn btn-outline-success btn-sm">
                                                        Lihat Kuis
                                                    </a>
                                                    <button type="button" class="btn btn-outline-secondary btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#toggleVisibilityModalQuiz{{ $quiz->id }}">
                                                        Perbarui Visibilitas
                                                    </button>
                                                </div>
                                            </div>
                                        </li>

                                        <div class="modal fade" id="toggleVisibilityModalQuiz{{ $quiz->id }}"
                                            tabindex="-1"
                                            aria-labelledby="toggleVisibilityModalLabelQuiz{{ $quiz->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <form method="POST"
                                                    action="{{ route('teacher.quizzes.toggleVisibility', $quiz->id) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="toggleVisibilityModalLabelQuiz{{ $quiz->id }}">
                                                                Perbarui Visibilitas Kuis
                                                            </h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Tutup"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Apakah Anda yakin ingin
                                                            <strong>{{ $quiz->visible ? 'menyembunyikan' : 'menampilkan' }}</strong>
                                                            kuis ini kepada siswa?
                                                        </div>
                                                        <input type="hidden" name="visible"
                                                            value="{{ $quiz->visible ? 0 : 1 }}">
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit"
                                                                class="btn btn-primary">Konfirmasi</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                </ul>
                            @endif

                            <!-- Buat Kuis dengan AI -->
                            <div class="d-flex justify-content-end mb-3">
                                <button type="button" class="btn btn-outline-primary tw-me-1" data-bs-toggle="modal"
                                    data-bs-target="#generateQuizModal{{ $module->id }}">
                                    <i class="bi bi-lightbulb"></i> Buat Kuis dengan AI
                                </button>
                                <a href="{{ route('teacher.quizzes.create', $module->id) }}" class="btn btn-primary">
                                    <i class="bi bi-file-earmark-text"></i> Tambah Kuis
                                </a>
                            </div>

                            <!-- Modal Buat Kuis -->
                            <div class="modal fade" id="generateQuizModal{{ $module->id }}" tabindex="-1"
                                aria-labelledby="generateQuizModalLabel{{ $module->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form action="{{ route('teacher.quizzes.generate', $module->id) }}" method="POST"
                                        enctype="multipart/form-data" onsubmit="showLoadingSpinner(event)">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="generateQuizModalLabel{{ $module->id }}">
                                                    Buat Kuis dengan AI</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Tutup"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="quizTitle" class="form-label">Judul Kuis</label>
                                                    <input type="text" class="form-control" id="quizTitle"
                                                        name="quizTitle" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="file" class="form-label">Unggah PDF</label>
                                                    <input type="file" class="form-control" id="file"
                                                        name="file" accept=".pdf">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="textContext" class="form-label">Atau Tempel Konten
                                                        Teks</label>
                                                    <textarea class="form-control" id="textContext" name="textContext" rows="4"></textarea>
                                                    <small class="text-muted">Anda dapat mengunggah PDF atau menempelkan
                                                        teks untuk membuat kuis.</small>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" id="generateQuizButton{{ $module->id }}"
                                                    class="btn btn-primary">
                                                    <i class="bi bi-lightbulb"></i> Buat Kuis
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- Assignments Section -->
                            <h5 class="text-secondary mt-4">Tugas</h5>
                            @if ($module->assignments->isEmpty())
                                <p class="text-danger">Tidak ada tugas untuk modul ini.</p>
                            @else
                                <ul class="list-group">
                                    @foreach ($module->assignments as $assignment)
                                        <li class="list-group-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <strong>{{ $assignment->title }}</strong>
                                                    <span
                                                        class="badge bg-{{ $assignment->visible ? 'success' : 'danger' }} ms-2">
                                                        {{ $assignment->visible ? 'Terlihat' : 'Tersembunyi' }}
                                                    </span>
                                                </div>
                                                <div>
                                                    <a href="{{ route('teacher.assignments.show', $assignment->id) }}"
                                                        class="btn btn-outline-success btn-sm">
                                                        Lihat Tugas
                                                    </a>
                                                    {{-- <button type="button" class="btn btn-outline-primary btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editAssignmentModal{{ $assignment->id }}">
                                                        Edit
                                                    </button> --}}
                                                    <button type="button" class="btn btn-outline-secondary btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#toggleVisibilityModalAssignment{{ $assignment->id }}">
                                                        Perbarui Visibilitas
                                                    </button>
                                                </div>
                                            </div>
                                        </li>

                                        <div class="modal fade" id="toggleVisibilityModalAssignment{{ $assignment->id }}"
                                            tabindex="-1"
                                            aria-labelledby="toggleVisibilityModalLabelAssignment{{ $assignment->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <form method="POST"
                                                    action="{{ route('teacher.assignments.toggleVisibility', $assignment->id) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="toggleVisibilityModalLabelAssignment{{ $assignment->id }}">
                                                                Perbarui Visibilitas Tugas
                                                            </h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Tutup"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Apakah Anda yakin ingin
                                                            <strong>{{ $assignment->visible ? 'menyembunyikan' : 'menampilkan' }}</strong>
                                                            tugas ini kepada siswa?
                                                        </div>
                                                        <input type="hidden" name="visible"
                                                            value="{{ $assignment->visible ? 0 : 1 }}">
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit"
                                                                class="btn btn-primary">Konfirmasi</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                    @endforeach
                                </ul>
                            @endif
                            <!-- Tombol Tambah Tugas -->
                            <div class="d-flex justify-content-end mb-3 tw-mt-5">
                                <button class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addAssignmentModal{{ $module->id }}">
                                    <i class="bi bi-plus-circle"></i> Tambah Tugas
                                </button>
                            </div>

                            <!-- Modal Tambah Tugas -->
                            <div class="modal fade" id="addAssignmentModal{{ $module->id }}" tabindex="-1"
                                aria-labelledby="addAssignmentModalLabel{{ $module->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form method="POST" action="{{ route('teacher.assignments.store', $module->id) }}">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="addAssignmentModalLabel{{ $module->id }}">
                                                    Tambah Tugas</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Tutup"></button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Judul -->
                                                <div class="mb-3">
                                                    <label for="assignmentTitle{{ $module->id }}"
                                                        class="form-label">Judul Tugas</label>
                                                    <input type="text" class="form-control"
                                                        id="assignmentTitle{{ $module->id }}" name="title" required>
                                                </div>
                                                <!-- Deskripsi -->
                                                <div class="mb-3">
                                                    <label for="assignmentDescription{{ $module->id }}"
                                                        class="form-label">Deskripsi Tugas</label>
                                                    <textarea class="form-control" id="assignmentDescription{{ $module->id }}" name="description" rows="3"
                                                        required></textarea>
                                                </div>
                                                <!-- Tenggat Waktu -->
                                                <div class="mb-3">
                                                    <label for="assignmentDeadline{{ $module->id }}"
                                                        class="form-label">Tenggat Waktu</label>
                                                    <input type="datetime-local" class="form-control"
                                                        id="assignmentDeadline{{ $module->id }}" name="deadline"
                                                        required>
                                                </div>
                                                <!-- Visibilitas -->
                                                <div class="mb-3">
                                                    <label for="assignmentVisible{{ $module->id }}"
                                                        class="form-label">Terlihat</label>
                                                    <select class="form-control"
                                                        id="assignmentVisible{{ $module->id }}" name="visible">
                                                        <option value="1">Ya</option>
                                                        <option value="0">Tidak</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Tutup</button>
                                                <button type="submit" class="btn btn-primary">Tambah Tugas</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>


                            <!-- Modal Tambah Pelajaran -->
                            <div class="modal fade" id="addLessonModal{{ $module->id }}" tabindex="-1"
                                aria-labelledby="addLessonModalLabel{{ $module->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form method="POST" action="{{ route('teacher.lessons.store', $module->id) }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="addLessonModalLabel{{ $module->id }}">
                                                    Tambah
                                                    Pelajaran</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Tutup"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="title" class="form-label">Judul Pelajaran</label>
                                                    <input type="text" class="form-control" id="title"
                                                        name="title" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="content" class="form-label">Unggah PDF</label>
                                                    <input type="file" class="form-control" id="content"
                                                        name="content" accept="application/pdf" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="visible" class="form-label">Terlihat</label>
                                                    <select class="form-control" id="visible" name="visible">
                                                        <option value="1">Ya</option>
                                                        <option value="0">Tidak</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Tutup</button>
                                                <button type="submit" class="btn btn-primary">Tambah Pelajaran</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Tautan ke Diskusi -->
                            @if ($module->discussion)
                                <div class="mb-4 text-end tw-mt-10">
                                    <a href="{{ route('discussions.show', $module->discussion->id) }}"
                                        class="btn btn-outline-primary">
                                        <i class="bi bi-chat-text"></i> Ke Diskusi
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <!-- Tombol Tambah Modul -->
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModuleModal">Tambah Modul</button>

        <!-- Modal Tambah Modul -->
        <div class="modal fade" id="addModuleModal" tabindex="-1" aria-labelledby="addModuleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" action="{{ route('teacher.modules.store', $course->id) }}">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addModuleModalLabel">Tambah Modul</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="title" class="form-label">Judul Modul</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Deskripsi Modul</label>
                                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Tambah Modul</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Tambahkan JavaScript -->
    <script>
        // Fungsi untuk menampilkan spinner
        function showLoadingSpinner(event) {
            console.log('Fungsi spinner dipicu'); // Debugging log

            // Mencegah pengiriman formulir default
            event.preventDefault();

            // Ambil tombol yang diklik
            const button = event.submitter || event.target.querySelector('button[type="submit"]');

            if (button) {
                // Nonaktifkan tombol dan tampilkan spinner
                button.disabled = true;
                button.innerHTML = `
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Sedang Membuat...
                        `;
            }

            // Opsional kirim formulir di sini
            // Batalkan komentar pada baris di bawah jika diperlukan pengiriman
            event.target.submit();
        }

        // Atur ulang semua tombol saat halaman dimuat
        window.onload = function() {
            console.log('Mengatur ulang status tombol'); // Debugging log

            // Pilih semua tombol kirim di dalam modal
            const buttons = document.querySelectorAll('button[id^="generateQuizButton"]');

            buttons.forEach((button) => {
                button.disabled = false; // Atur ulang status nonaktif
                button.innerHTML = '<i class="bi bi-lightbulb"></i> Buat Kuis'; // Atur ulang konten
            });
        };
    </script>
@endsection
