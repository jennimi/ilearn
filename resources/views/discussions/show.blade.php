@extends('layouts.app')

@section('content')
    <div class="container">
        <div>
            <a href="{{ route('student.courses.show', $discussion->module->course->id) }}" class="btn btn-warning me-2"><i
                    class="bi bi-arrow-left tw-me-2 tw-fs-4 tw-group-hover:tw-text-blue-500"></i>
                <span class="tw-group-hover:tw-underline">Kembali ke Modul</span></a>
        </div>
        <h1>{{ $discussion->title }} | {{ $discussion->module->course->title }}</h1>
        <p>Modul: {{ $discussion->module->title }}</p>

        <h3>Komentar</h3>
        @if ($discussion->comments->isEmpty())
            <p>Belum ada komentar.</p>
        @else
            <ul class="list-group mb-3">
                @foreach ($discussion->comments as $comment)
                    <li class="list-group-item">
                        <strong>{{ $comment->user->name }}:</strong> <!-- Tampilkan nama pengguna -->
                        {{ $comment->comment }}
                        <br>
                        <small>Diposting pada: {{ $comment->created_at->format('Y-m-d H:i') }}</small>

                        <!-- Bagian Balasan -->
                        @if ($comment->replies->isNotEmpty())
                            <button class="btn btn-link btn-sm mt-2" type="button" data-bs-toggle="collapse"
                                data-bs-target="#replies{{ $comment->id }}" aria-expanded="false"
                                aria-controls="replies{{ $comment->id }}">
                                Lihat Balasan ({{ $comment->replies->count() }})
                            </button>

                            <div class="collapse mt-2" id="replies{{ $comment->id }}">
                                <ul class="list-group">
                                    @foreach ($comment->replies as $reply)
                                        <li class="list-group-item">
                                            <strong>{{ $reply->user->name }}:</strong> <!-- Tampilkan nama pengguna balasan -->
                                            {{ $reply->comment }}
                                            <br>
                                            <small>Diposting pada: {{ $reply->created_at->format('Y-m-d H:i') }}</small>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Form Balasan untuk Guru -->
                        @if (auth()->user()->role === 'teacher')
                            <form method="POST" action="{{ route('teacher.comments.reply', $comment->id) }}" class="mt-2">
                                @csrf
                                <div class="mb-3">
                                    <textarea class="form-control" name="comment" rows="2" required
                                        placeholder="Tulis balasan Anda..."></textarea>
                                </div>
                                <button type="submit" class="btn btn-sm btn-primary">Balas</button>
                            </form>
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif

        <!-- Form Tambah Komentar untuk Siswa -->
        @if (auth()->user()->role === 'student')
            <h4>Tambah Komentar</h4>
            <form method="POST" action="{{ route('discussions.comment.store', $discussion->id) }}">
                @csrf
                <div class="mb-3">
                    <textarea class="form-control" name="comment" rows="3" required
                        placeholder="Tulis komentar Anda..."></textarea>
                </div>
                <button type="submit" class="btn btn-success">Posting Komentar</button>
            </form>
        @endif
    </div>
@endsection
