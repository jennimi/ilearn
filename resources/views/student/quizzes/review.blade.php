@extends('layouts.app')

@section('content')
    <div class="container">
        <div>
            <a href="{{ route('student.courses.show', $quiz->module->course->id) }}" class="btn btn-warning me-2"><i
                    class="bi bi-arrow-left tw-me-2 tw-fs-4 tw-group-hover:tw-text-blue-500"></i>
                <span class="tw-group-hover:tw-underline">Kembali</span></a>
        </div>
        <h1 class="text-primary">{{ $quiz->title }} - Ulasan</h1>

        {{-- Ambil hasil kuis siswa --}}
        @php
            $quizResult = $quiz->quizResults->firstWhere('student_id', Auth::user()->student->id) ?? null;
            $score = $quizResult ? $quizResult->score : null;
            $badgeClass =
                $score === null
                    ? 'bg-secondary'
                    : ($score < 50
                        ? 'bg-danger'
                        : ($score <= 80
                            ? 'bg-warning text-dark'
                            : 'bg-success'));
        @endphp

        {{-- Tampilkan skor dalam badge atau pesan fallback --}}
        <p>
            <strong>Skor Anda:</strong>
            @if ($score !== null)
                <span class="badge {{ $badgeClass }}">{{ $score }}%</span>
            @else
                <span class="badge bg-secondary">Skor tidak tersedia</span>
            @endif
        </p>

        {{-- Iterasi melalui pertanyaan --}}
        @foreach ($quiz->questions as $question)
            <div class="mb-4 border rounded p-3 bg-light">
                {{-- Tampilkan teks pertanyaan --}}
                <h5 class="mb-3">{{ $question->question_text }}</h5>

                {{-- Tampilkan gambar pertanyaan jika ada --}}
                @if ($question->image)
                    <img src="{{ asset('storage/' . $question->image) }}" alt="Gambar Pertanyaan" class="img-fluid mb-3">
                @endif

                {{-- Tangani jawaban berdasarkan jenis pertanyaan --}}
                @if (in_array($question->question_type, ['', 'single_choice', 'multiple_choice']))
                    @foreach ($question->choices as $choice)
                        <div class="mb-2">
                            <span>{{ $choice->choice_text }}</span>

                            {{-- Periksa apakah siswa memilih pilihan ini --}}
                            @php
                                $selectedAnswer = $question->answers
                                    ->where('student_id', Auth::user()->student->id)
                                    ->where('answer_key', $choice->id)
                                    ->first();
                            @endphp

                            @if ($selectedAnswer)
                                <span class="badge bg-info">Jawaban Anda</span>
                            @endif
                        </div>
                    @endforeach
                @elseif ($question->question_type == 'short_answer')
                    {{-- Tangani jawaban singkat --}}
                    @php
                        $studentAnswer = $question->answers->where('student_id', Auth::user()->student->id)->first();
                    @endphp
                    <p>
                        <strong>Jawaban Anda:</strong> {{ $studentAnswer->answer_text ?? 'Tidak Dijawab' }}
                    </p>
                @endif
            </div>
        @endforeach
    </div>
@endsection
