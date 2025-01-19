@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">
            Edit Kuis
            <small class="text-muted">({{ $quiz->module->course->name }} - {{ $quiz->module->name }})</small>
        </h1>

        <!-- Tombol Hapus Kuis -->
        <button type="button" class="btn btn-outline-danger mb-4" data-bs-toggle="modal" data-bs-target="#deleteQuizModal">
            <i class="bi bi-trash"></i> Hapus Kuis
        </button>

        <form method="POST" action="{{ route('teacher.quizzes.update', $quiz->id) }}" id="editQuizForm">
            @csrf
            @method('PUT')

            <!-- Detail Kuis -->
            <div class="mb-4">
                <label for="title" class="form-label">Judul Kuis</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ $quiz->title }}" required>
            </div>

            <div class="mb-4">
                <label for="description" class="form-label">Deskripsi Kuis</label>
                <textarea class="form-control" id="description" name="description" rows="3">{{ $quiz->description }}</textarea>
            </div>

            <div class="mb-4">
                <label for="deadline" class="form-label">Batas Waktu Kuis</label>
                <input type="datetime-local" class="form-control" id="deadline" name="deadline"
                    value="{{ $quiz->deadline ? $quiz->deadline->format('Y-m-d\TH:i') : '' }}">
            </div>

            <div class="mb-4">
                <label for="duration" class="form-label">Durasi (Menit)</label>
                <input type="number" class="form-control" id="duration" name="duration" min="1"
                    value="{{ $quiz->duration }}">
            </div>

            <!-- Bagian Pertanyaan -->
            <div class="mb-4">
                <h4>Pertanyaan</h4>
                <button type="button" class="btn btn-outline-primary mb-3" data-bs-toggle="modal"
                    data-bs-target="#addQuestionModal">
                    <i class="bi bi-plus-circle"></i> Tambah Pertanyaan
                </button>

                <div id="questionsContainer">
                    @foreach ($quiz->questions as $question)
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5>Pertanyaan {{ $loop->iteration }}</h5>
                                <p><strong>Teks:</strong> {{ $question->question_text }}</p>
                                <p><strong>Poin:</strong> {{ $question->points }}</p>
                                <p><strong>Tipe:</strong> {{ $question->getTypeLabel() }}</p>

                                @if ($question->image)
                                    <img src="{{ asset('storage/' . $question->image) }}" alt="Gambar Pertanyaan"
                                        class="img-fluid mb-3">
                                @endif

                                <!-- Tampilkan Pilihan Pertanyaan -->
                                <h6>Pilihan:</h6>
                                <ul>
                                    @foreach ($question->choices as $choice)
                                        <li>
                                            {{ $choice->choice_text }}
                                            @if ($choice->is_correct)
                                                <span class="badge bg-success">Benar</span>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>

                                <!-- Tombol Aksi -->
                                <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#editQuestionModal{{ $question->id }}">
                                    Edit
                                </button>
                                <form action="{{ route('teacher.questions.destroy', $question->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">Hapus</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        </form>
    </div>

    <!-- Modal Tambah Pertanyaan -->
    <div class="modal fade" id="addQuestionModal" tabindex="-1" aria-labelledby="addQuestionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="addQuestionForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addQuestionModalLabel">Tambah Pertanyaan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Mirip dengan struktur modal "Create Quiz" -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-primary">Simpan Pertanyaan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Pertanyaan -->
    @foreach ($quiz->questions as $question)
        <div class="modal fade" id="editQuestionModal{{ $question->id }}" tabindex="-1"
            aria-labelledby="editQuestionModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" action="{{ route('teacher.questions.update', $question->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editQuestionModalLabel">Edit Pertanyaan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Teks Pertanyaan -->
                            <div class="mb-3">
                                <label for="edit_question_text_{{ $question->id }}" class="form-label">Teks Pertanyaan</label>
                                <textarea class="form-control" id="edit_question_text_{{ $question->id }}" name="question_text" rows="3"
                                    required>{{ $question->question_text }}</textarea>
                            </div>

                            <!-- Poin Pertanyaan -->
                            <div class="mb-3">
                                <label for="edit_question_points_{{ $question->id }}" class="form-label">Poin</label>
                                <input type="number" class="form-control" id="edit_question_points_{{ $question->id }}"
                                    name="points" value="{{ $question->points }}" required>
                            </div>

                            <!-- Tipe Pertanyaan -->
                            <div class="mb-3">
                                <label for="edit_question_type_{{ $question->id }}" class="form-label">Tipe Pertanyaan</label>
                                <select class="form-select" id="edit_question_type_{{ $question->id }}"
                                    name="question_type" required>
                                    <option value="0" {{ $question->type == 0 ? 'selected' : '' }}>Pilihan Tunggal</option>
                                    <option value="1" {{ $question->type == 1 ? 'selected' : '' }}>Pilihan Ganda</option>
                                    <option value="2" {{ $question->type == 2 ? 'selected' : '' }}>Jawaban Singkat</option>
                                </select>
                            </div>

                            <!-- Pilihan Pertanyaan -->
                            <div id="edit_question_choices_{{ $question->id }}">
                                <h6>Pilihan</h6>
                                @foreach ($question->choices as $choice)
                                    <div class="mb-3 d-flex align-items-center">
                                        <input type="text" class="form-control me-2"
                                            name="choices[{{ $choice->id }}][choice_text]"
                                            value="{{ $choice->choice_text }}" required>
                                        <input type="hidden" name="choices[{{ $choice->id }}][id]"
                                            value="{{ $choice->id }}">
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" class="form-check-input"
                                                id="is_correct_{{ $choice->id }}"
                                                name="choices[{{ $choice->id }}][is_correct]" value="1"
                                                {{ $choice->is_correct ? 'checked' : '' }} hidden>
                                            <label class="form-check-label"
                                                for="is_correct_{{ $choice->id }}">Benar</label>
                                        </div>
                                        <button type="button" class="btn btn-danger btn-sm remove-choice" onclick="this.parentElement.remove();">
                                            <i class="bi bi-x-circle"></i> Hapus
                                        </button>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Tombol Tambah Pilihan Baru -->
                            <button type="button" class="btn btn-outline-secondary btn-sm"
                                id="addChoiceBtn_{{ $question->id }}" onclick="addChoiceField({{ $question->id }})">
                                <i class="bi bi-plus-circle"></i> Tambah Pilihan Baru
                            </button>
                            <div id="newChoicesContainer_{{ $question->id }}"></div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endforeach

    <!-- Modal Hapus Kuis -->
    <div class="modal fade" id="deleteQuizModal" tabindex="-1" aria-labelledby="deleteQuizModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('teacher.quizzes.destroy', $quiz->id) }}">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteQuizModalLabel">Hapus Kuis</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menghapus kuis ini?</p>
                        <p class="text-danger">
                            Tindakan ini akan menghapus semua pertanyaan dan pilihan yang terkait dengan kuis dan tidak dapat dibatalkan.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus Kuis</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

<script>
    function addChoiceField(questionId) {
        const container = document.getElementById(`newChoicesContainer_${questionId}`);
        const newField = document.createElement('div');
        newField.classList.add('mb-3', 'd-flex', 'align-items-center');
        newField.innerHTML = `
            <input type="text" class="form-control me-2" name="new_choices[${questionId}][]" placeholder="Masukkan teks pilihan" required>
            <div class="form-check form-check-inline">
                <input type="checkbox" class="form-check-input" name="new_choices_correct[${questionId}][]" value="1">
                <label class="form-check-label">Benar</label>
            </div>
            <button type="button" class="btn btn-danger btn-sm remove-choice" onclick="this.parentElement.remove();">
                <i class="bi bi-x-circle"></i> Hapus
            </button>
        `;
        container.appendChild(newField);
    }
</script>
