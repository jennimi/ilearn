@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">
            Kuis AI-Generated
            <small class="text-muted">({{ $courseName }} - {{ $moduleName }})</small>
        </h1>
        <form method="POST" action="{{ route('teacher.quizzes.store', $module->id) }}" id="createQuizForm">
            @csrf

            <div class="mb-4">
                <label for="title" class="form-label">Judul Kuis</label>
                <input type="text" class="form-control" id="title" name="title"
                    value="{{ $preFilledQuiz['title'] }}" required>
            </div>

            <div class="mb-4">
                <label for="description" class="form-label">Deskripsi Kuis</label>
                <textarea class="form-control" id="description" name="description" rows="3">{{ $preFilledQuiz['description'] }}</textarea>
            </div>

            <div class="mb-4">
                <label for="deadline" class="form-label">Batas Waktu Kuis</label>
                <input type="datetime-local" class="form-control" id="deadline" name="deadline">
            </div>

            <div class="mb-4">
                <label for="duration" class="form-label">Durasi (Menit)</label>
                <input type="number" class="form-control" id="duration" name="duration" min="1">
            </div>

            <!-- Bagian Pertanyaan -->
            <div class="mb-4">
                <h4>Pertanyaan</h4>
                <button type="button" class="btn btn-outline-primary mb-3" data-bs-toggle="modal"
                    data-bs-target="#addQuestionModal">
                    <i class="bi bi-plus-circle"></i> Tambah Pertanyaan
                </button>
                <div id="questionsContainer">
                    @foreach ($preFilledQuiz['questions'] ?? [] as $index => $question)
                        <div class="card mb-3 question-card" data-index="{{ $index }}">
                            <div class="card-body">
                                <h5>{{ $question['question_text'] }}</h5>
                                <p class="text-muted">Tipe:
                                    {{ $question['question_type'] === '0' ? 'Pilihan Tunggal' : ($question['question_type'] === '1' ? 'Pilihan Ganda' : 'Jawaban Singkat') }}
                                </p>
                                <p class="text-muted">Poin: {{ $question['points'] }}</p>
                                <ul>
                                    @foreach ($question['choices'] as $choiceIndex => $choice)
                                        <li>
                                            {{ $choice['choice_text'] }}
                                            @if (!empty($choice['is_correct']))
                                                <span class="badge bg-success ms-2">Benar</span>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-outline-primary btn-sm edit-question-button"
                                        data-bs-toggle="modal" data-bs-target="#editQuestionModal"
                                        data-index="{{ $index }}">Edit</button>
                                    <button type="button" class="btn btn-outline-danger btn-sm delete-question-button"
                                        data-index="{{ $index }}">Hapus</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Input Tersembunyi untuk Data Pertanyaan -->
            <input type="hidden" name="questions" id="questionsData">

            <button type="submit" class="btn btn-success">Buat Kuis</button>
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
                        <div class="mb-3">
                            <label for="question_text" class="form-label">Teks Pertanyaan</label>
                            <textarea class="form-control" id="question_text" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="question_points" class="form-label">Poin</label>
                            <input type="number" class="form-control" id="question_points"
                                placeholder="Poin untuk pertanyaan ini" min="1" required>
                        </div>
                        <div class="mb-3">
                            <label for="question_type" class="form-label">Tipe Pertanyaan</label>
                            <select class="form-select" id="question_type" required>
                                <option value="" disabled selected>Silakan pilih tipe pertanyaan</option>
                                <option value="0">Pilihan Tunggal</option>
                                <option value="1">Pilihan Ganda</option>
                                <option value="2">Jawaban Singkat</option>
                            </select>
                        </div>

                        <div id="answerOptions" class="d-none">
                            <h6 class="mb-3">Pilihan Jawaban</h6>
                            <div id="answerFields"></div>
                            <button type="button" class="btn btn-outline-secondary add-answer"><i
                                    class="bi bi-plus-circle"></i> Tambah Jawaban Lain</button>
                        </div>

                        <div id="correctAnswerField" class="d-none">
                            <label for="short_correct_answer" class="form-label">Jawaban Benar (Jawaban Singkat)</label>
                            <input type="text" class="form-control" id="short_correct_answer"
                                placeholder="Masukkan jawaban yang benar">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-primary" id="saveQuestionButton">Simpan Pertanyaan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Pertanyaan -->
    <div class="modal fade" id="editQuestionModal" tabindex="-1" aria-labelledby="editQuestionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form id="editQuestionForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editQuestionModalLabel">Edit Pertanyaan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_question_text" class="form-label">Teks Pertanyaan</label>
                            <textarea class="form-control" id="edit_question_text" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit_question_points" class="form-label">Poin</label>
                            <input type="number" class="form-control" id="edit_question_points"
                                placeholder="Poin untuk pertanyaan ini" min="1" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_question_type" class="form-label">Tipe Pertanyaan</label>
                            <select class="form-select" id="edit_question_type" required>
                                <option value="0">Pilihan Tunggal</option>
                                <option value="1">Pilihan Ganda</option>
                                <option value="2">Jawaban Singkat</option>
                            </select>
                        </div>

                        <div id="edit_answerOptions" class="d-none">
                            <h6 class="mb-3">Pilihan Jawaban</h6>
                            <div id="edit_answerFields"></div>
                            <button type="button" class="btn btn-outline-secondary add-answer"><i
                                    class="bi bi-plus-circle"></i> Tambah Jawaban Lain</button>
                        </div>

                        <div id="edit_correctAnswerField" class="d-none">
                            <label for="edit_short_correct_answer" class="form-label">Jawaban Benar (Jawaban
                                Singkat)</label>
                            <input type="text" class="form-control" id="edit_short_correct_answer"
                                placeholder="Masukkan jawaban yang benar">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-primary" id="saveEditedQuestionButton">Simpan
                            Perubahan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        const addQuestionForm = document.getElementById('addQuestionForm');
        const saveQuestionButton = document.getElementById('saveQuestionButton');
        const questionsContainer = document.getElementById('questionsContainer');
        const questionsDataInput = document.getElementById('questionsData');
        const questionTypeDropdown = document.getElementById('question_type');
        const answerFields = document.getElementById('answerFields');
        const answerOptions = document.getElementById('answerOptions');
        const correctAnswerField = document.getElementById('correctAnswerField');
        const editQuestionForm = document.getElementById('editQuestionForm');
        const saveEditedQuestionButton = document.getElementById('saveEditedQuestionButton');

        // Inisialisasi array pertanyaan dengan pertanyaan kuis yang sudah diisi sebelumnya
        let questions = @json($preFilledQuiz['questions'] ?? []);

        // Render pertanyaan saat halaman dimuat
        renderQuestions();

        // Reset modal saat dibuka
        document.getElementById('addQuestionModal').addEventListener('show.bs.modal', function() {
            addQuestionForm.reset();
            questionTypeDropdown.value = "";
            answerFields.innerHTML = "";
            answerOptions.classList.add('d-none');
            correctAnswerField.classList.add('d-none');
        });

        document.getElementById('createQuizForm').addEventListener('submit', function(event) {
            if (questions.length === 0) {
                alert('Silakan tambahkan setidaknya satu pertanyaan sebelum mengirimkan.');
                event.preventDefault();
                return;
            }
        });

        // Tampilkan atau sembunyikan bidang berdasarkan jenis pertanyaan
        questionTypeDropdown.addEventListener('change', function() {
            if (this.value === '0') { // Pilihan Tunggal
                answerOptions.classList.remove('d-none');
                correctAnswerField.classList.add('d-none');
                renderAnswerInputs('radio');
            } else if (this.value === '1') { // Pilihan Ganda
                answerOptions.classList.remove('d-none');
                correctAnswerField.classList.add('d-none');
                renderAnswerInputs('checkbox');
            } else if (this.value === '2') { // Jawaban Singkat
                answerOptions.classList.add('d-none');
                correctAnswerField.classList.remove('d-none');
            }
        });

        // Logika tambahkan jawaban
        document.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('add-answer')) {
                const choiceIndex = answerFields.children.length;
                const type = questionTypeDropdown.value === '0' ? 'radio' : 'checkbox';
                const choiceDiv = document.createElement('div');
                choiceDiv.classList.add('input-group', 'mb-3');
                choiceDiv.innerHTML = `
                    <input type="text" class="form-control choice-text" placeholder="Pilihan Jawaban" required>
                    <input type="${type}" name="correct_answer" class="form-check-input correct-choice" value="${choiceIndex}">
                    <button type="button" class="btn btn-danger remove-answer"><i class="bi bi-x-circle"></i> Hapus</button>
                `;
                answerFields.appendChild(choiceDiv);

                // Logika hapus jawaban
                choiceDiv.querySelector('.remove-answer').addEventListener('click', function() {
                    choiceDiv.remove();
                });
            }
        });

        // Simpan Pertanyaan
        saveQuestionButton.addEventListener('click', function() {
            const questionText = document.getElementById('question_text').value.trim();
            const questionType = questionTypeDropdown.value;
            const questionPoints = parseInt(document.getElementById('question_points').value, 10);

            const choices = Array.from(answerFields.querySelectorAll('.choice-text'))
                .map(input => input.value.trim())
                .filter(choice => choice !== '');
            const correctAnswers = questionType === '0' ? [Array.from(answerFields.querySelectorAll(
                    '.correct-choice')).findIndex(input => input.checked)] :
                questionType === '1' ?
                Array.from(answerFields.querySelectorAll('.correct-choice'))
                .map((input, index) => (input.checked ? index : null))
                .filter(index => index !== null) : [];
            const shortAnswer = questionType === '2' ? document.getElementById('short_correct_answer')
                .value.trim() : null;

            // Validasi
            if (!questionText) {
                alert('Silakan masukkan teks pertanyaan.');
                return;
            }
            if ((questionType === '0' || questionType === '1') && choices.length === 0) {
                alert('Silakan tambahkan setidaknya satu pilihan jawaban.');
                return;
            }
            if (questionType === '0' && correctAnswers.length !== 1) {
                alert('Silakan pilih tepat satu jawaban benar untuk Pilihan Tunggal.');
                return;
            }
            if (questionType === '2' && !shortAnswer) {
                alert('Silakan masukkan jawaban yang benar untuk pertanyaan Jawaban Singkat.');
                return;
            }
            if (!questionPoints || questionPoints < 1) {
                alert('Silakan masukkan poin yang valid untuk pertanyaan.');
                return;
            }

            // Buat objek pertanyaan
            const question = {
                question_text: questionText,
                question_type: questionType,
                points: questionPoints,
                choices: questionType !== '2' ? choices : [],
                correct_answers: questionType === '2' ? [shortAnswer] : correctAnswers,
            };

            questions.push(question);
            renderQuestions();

            // Simpan pertanyaan sebagai JSON di input tersembunyi
            questionsDataInput.value = JSON.stringify(questions);

            // Reset dan tutup modal
            addQuestionForm.reset();
            answerFields.innerHTML = '';
            bootstrap.Modal.getInstance(document.getElementById('addQuestionModal')).hide();
        });

        function renderQuestions() {
            questionsContainer.innerHTML = ''; // Bersihkan pertanyaan yang ada

            questions.forEach((question, index) => {
                const questionDiv = document.createElement('div');
                questionDiv.classList.add('card', 'mb-3');
                questionDiv.innerHTML = `
                    <div class="card-body">
                        <h5>${question.question_text}</h5>
                        <p class="text-muted">Tipe: ${question.question_type === '0' ? 'Pilihan Tunggal' : question.question_type === '1' ? 'Pilihan Ganda' : 'Jawaban Singkat'}</p>
                        <p class="text-muted">Poin: ${question.points}</p>
                        <ul>
                            ${question.choices.map((choice, i) => `
                                    <li>
                                        ${choice} ${question.correct_answers.includes(i) ? '<span class="badge bg-success ms-2">Benar</span>' : ''}
                                    </li>`).join('')}
                        </ul>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-outline-primary btn-sm edit-question-button" data-bs-toggle="modal" data-bs-target="#editQuestionModal" data-index="${index}">Edit</button>
                            <button type="button" class="btn btn-outline-danger btn-sm delete-question-button" data-index="${index}">Hapus</button>
                        </div>
                    </div>
                `;

                // Tambahkan event listener
                questionDiv.querySelector('.edit-question-button').addEventListener('click', function() {
                    editQuestion(this.dataset.index);
                });

                questionDiv.querySelector('.delete-question-button').addEventListener('click', function() {
                    deleteQuestion(this.dataset.index);
                });

                questionsContainer.appendChild(questionDiv);
            });

            // Perbarui input tersembunyi
            questionsDataInput.value = JSON.stringify(questions);
        }

        // Fungsi Edit Pertanyaan
        function editQuestion(index) {
            const question = questions[index];

            // Isi data di modal Edit
            document.getElementById('edit_question_text').value = question.question_text;
            document.getElementById('edit_question_points').value = question.points;
            document.getElementById('edit_question_type').value = question.question_type;

            const editAnswerFields = document.getElementById('edit_answerFields');
            const editAnswerOptions = document.getElementById('edit_answerOptions');
            const editCorrectAnswerField = document.getElementById('edit_correctAnswerField');

            // Reset bidang
            editAnswerFields.innerHTML = '';
            editAnswerOptions.classList.add('d-none');
            editCorrectAnswerField.classList.add('d-none');

            // Tampilkan atau sembunyikan bidang berdasarkan tipe pertanyaan
            if (question.question_type === '0' || question.question_type === '1') {
                editAnswerOptions.classList.remove('d-none');
                question.choices.forEach((choice, i) => {
                    const choiceDiv = document.createElement('div');
                    choiceDiv.classList.add('input-group', 'mb-3');
                    const type = question.question_type === '0' ? 'radio' : 'checkbox';
                    choiceDiv.innerHTML = `
                        <input type="text" class="form-control choice-text" value="${choice}" required>
                        <input type="${type}" name="edit_correct_answer" class="form-check-input correct-choice" ${question.correct_answers.includes(i) ? 'checked' : ''}>
                        <button type="button" class="btn btn-danger remove-answer"><i class="bi bi-x-circle"></i> Hapus</button>
                    `;
                    editAnswerFields.appendChild(choiceDiv);
                });
            } else if (question.question_type === '2') {
                editCorrectAnswerField.classList.remove('d-none');
                document.getElementById('edit_short_correct_answer').value = question.correct_answers[0];
            }

            saveEditedQuestionButton.dataset.index = index;
        }

        // Hapus Pertanyaan
        function deleteQuestion(index) {
            if (confirm('Apakah Anda yakin ingin menghapus pertanyaan ini?')) {
                questions.splice(index, 1);
                renderQuestions();
            }
        }
    </script>
@endsection
