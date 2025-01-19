@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h1>{{ $quiz->title }}</h1>
                <p>{{ $quiz->description }}</p>
            </div>
            <div class="card-body">
                @if ($quiz->duration)
                    <div class="alert alert-warning">
                        <strong>Waktu Tersisa:</strong>
                        <span id="timeRemaining">{{ $quiz->duration }}:00</span>
                    </div>
                @endif

                <!-- Start Quiz Modal -->
                <div class="modal fade" id="startQuizModal" tabindex="-1" aria-labelledby="startQuizModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="startQuizModalLabel">Konfirmasi Mulai</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Tutup"></button>
                            </div>
                            <div class="modal-body">
                                Apakah Anda yakin ingin memulai kuis? Setelah dimulai, pengatur waktu akan berjalan.
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="button" class="btn btn-primary" id="confirmStartQuizButton">Mulai
                                    Kuis</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Sidebar for navigation -->
                    <div class="col-md-3 d-none d-md-none" id="questionList">
                        <div class="sticky-top" style="top: 20px;">
                            <table class="table table-bordered">
                                <tbody>
                                    @foreach ($quiz->questions->chunk(5) as $row)
                                        <tr>
                                            @foreach ($row as $index => $question)
                                                <td class="text-center">
                                                    <button class="btn btn-outline-primary question-nav"
                                                        data-index="{{ $loop->parent->index * 5 + $index }}">
                                                        {{ $loop->parent->index * 5 + $index + 1 }}
                                                    </button>
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Quiz Content -->
                    <div class="col-md-9">
                        <button type="button" id="startQuizButton" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#startQuizModal">Mulai Kuis</button>
                        <form id="quizForm" action="{{ route('student.quizzes.submit', $quiz->id) }}" method="POST">
                            @csrf
                            <div id="questionsContainer">
                                @foreach ($quiz->questions as $index => $question)
                                    <div class="question" data-question-id="{{ $question->id }}"
                                        data-index="{{ $index }}" style="display: none;">
                                        <div class="mb-4">
                                            <h5 class="fw-bold">{{ $question->question_text }}</h5>
                                            @if ($question->image)
                                                <img src="{{ asset('storage/' . $question->image) }}" alt="Gambar Pertanyaan"
                                                    class="img-fluid mb-3">
                                            @endif
                                            <p><strong>Jenis:</strong> {{ $question->getTypeLabel() }}</p>
                                        </div>

                                        @if ($question->getTypeLabel() === 'Pilihan Tunggal')
                                            <div class="choices">
                                                @foreach ($question->choices as $choice)
                                                    <div class="form-check fancy-input">
                                                        <input class="form-check-input-take" type="radio"
                                                            name="answers[{{ $question->id }}]"
                                                            value="{{ $choice->id }}" id="choice{{ $choice->id }}">
                                                        <label class="form-check-label radio"
                                                            for="choice{{ $choice->id }}">
                                                            {{ $choice->choice_text }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @elseif ($question->getTypeLabel() === 'Pilihan Ganda')
                                            <div class="choices">
                                                @foreach ($question->choices as $choice)
                                                    <div class="form-check fancy-input">
                                                        <input class="form-check-input-take" type="checkbox"
                                                            name="answers[{{ $question->id }}][]"
                                                            value="{{ $choice->id }}" id="choice{{ $choice->id }}">
                                                        <label class="form-check-label checkbox"
                                                            for="choice{{ $choice->id }}">
                                                            {{ $choice->choice_text }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @elseif ($question->getTypeLabel() === 'Jawaban Singkat')
                                            <div class="choices">
                                                <input type="text" name="answers[{{ $question->id }}]"
                                                    class="form-control" placeholder="Ketik jawaban Anda di sini">
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            <div class="d-flex justify-content-between mt-4">

                                <div class="btn-group" role="group">
                                    <button type="button" id="previousQuestionButton" class="btn btn-outline-secondary"
                                        style="display: none;">Sebelumnya</button>
                                    <button type="button" id="nextQuestionButton" class="btn btn-outline-secondary"
                                        style="display: none;">Berikutnya</button>
                                </div>

                                <button type="submit" id="submitQuizButton" class="btn btn-success"
                                    style="display: none;">Kirim Kuis</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const startButton = document.getElementById('startQuizButton');
            const confirmStartButton = document.getElementById('confirmStartQuizButton');
            const previousButton = document.getElementById('previousQuestionButton');
            const nextButton = document.getElementById('nextQuestionButton');
            const submitButton = document.getElementById('submitQuizButton');
            const questionList = document.getElementById('questionList');
            const questions = Array.from(document.querySelectorAll('.question'));
            const questionNavButtons = Array.from(document.querySelectorAll('.question-nav'));
            const timerElement = document.getElementById('timeRemaining');
            const quizForm = document.getElementById('quizForm');
            let currentQuestionIndex = 0;

            @if ($quiz->duration)
                let timeRemaining = {{ $quiz->duration }} * 60; // Convert minutes to seconds
                let timerInterval;

                function updateTimer() {
                    const minutes = Math.floor(timeRemaining / 60);
                    const seconds = timeRemaining % 60;
                    timerElement.textContent = `${minutes}:${seconds < 10 ? '0' + seconds : seconds}`;

                    if (timeRemaining <= 0) {
                        clearInterval(timerInterval);
                        alert('Waktu habis! Kuis Anda akan dikirim sekarang.');
                        quizForm.submit(); // Automatically submit the quiz
                    }

                    timeRemaining--;
                }
            @endif

            function showQuestion(index) {
                questions.forEach((question, i) => {
                    question.style.display = i === index ? 'block' : 'none';
                });

                previousButton.style.display = index > 0 ? 'inline-block' : 'none';
                nextButton.style.display = index < questions.length - 1 ? 'inline-block' : 'none';
                submitButton.style.display = index === questions.length - 1 ? 'inline-block' : 'none';

                questionNavButtons.forEach(button => button.classList.remove('active'));
                if (questionNavButtons[index]) {
                    questionNavButtons[index].classList.add('active');
                }
            }

            confirmStartButton.addEventListener('click', function() {
                // Correctly hide the modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('startQuizModal'));
                modal.hide(); // Close modal

                // Hide start button, show quiz UI
                startButton.style.display = 'none';
                questionList.classList.remove('d-md-none');
                questionList.classList.add('d-md-block');
                showQuestion(currentQuestionIndex);

                @if ($quiz->duration)
                    timerInterval = setInterval(updateTimer, 1000);
                @endif
            });

            previousButton.addEventListener('click', function() {
                if (currentQuestionIndex > 0) {
                    currentQuestionIndex--;
                    showQuestion(currentQuestionIndex);
                }
            });

            nextButton.addEventListener('click', function() {
                if (currentQuestionIndex < questions.length - 1) {
                    currentQuestionIndex++;
                    showQuestion(currentQuestionIndex);
                }
            });

            questionNavButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const index = parseInt(this.getAttribute('data-index'));
                    currentQuestionIndex = index;
                    showQuestion(currentQuestionIndex);
                });
            });
        });
    </script>
@endsection
