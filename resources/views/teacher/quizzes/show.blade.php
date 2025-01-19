@extends('layouts.app')

@section('content')
    <div class="container">
        <div>
            <button onclick="window.history.back()" class="btn btn-warning me-2">
                <i class="bi bi-arrow-left tw-me-2 tw-fs-4 tw-group-hover:tw-text-blue-500"></i>
                <span class="tw-group-hover:tw-underline">Kembali</span>
            </button>
        </div>
        <h1>{{ $quiz->title }}</h1>
        <p>{{ $quiz->description }}</p>

        <div class="d-flex justify-content-end mb-4">
            <a href="{{ route('teacher.quizzes.edit', $quiz->id) }}" class="btn btn-outline-primary">
                <i class="bi bi-pencil"></i> Edit Kuis
            </a>
        </div>

        <h3>Pertanyaan</h3>
        @if ($quiz->questions->isEmpty())
            <p>Belum ada pertanyaan yang ditambahkan.</p>
        @else
            @foreach ($quiz->questions as $question)
                <div class="card mb-3">
                    <div class="card-body">
                        <!-- Judul Pertanyaan -->
                        <h5 class="card-title">Pertanyaan {{ $loop->iteration }}</h5>
                        <p><strong>Teks Pertanyaan:</strong> {{ $question->question_text }}</p>

                        <!-- Gambar Pertanyaan (jika tersedia) -->
                        @if ($question->image)
                            <img src="{{ asset('storage/' . $question->image) }}" alt="Gambar Pertanyaan" class="img-fluid mb-3">
                        @endif

                        <!-- Jenis Pertanyaan dan Poin -->
                        <p><strong>Jenis:</strong>
                            {{ $question->getTypeLabel() }}
                        </p>
                        <p><strong>Poin: </strong> {{ $question->points }}</p>

                        <!-- Pilihan atau Jawaban Benar -->
                        @if ($question->choices->isNotEmpty())
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
                        @else
                            <p>Tidak ada pilihan untuk pertanyaan ini.</p>
                        @endif

                    </div>
                </div>
            @endforeach
        @endif
    </div>
@endsection
