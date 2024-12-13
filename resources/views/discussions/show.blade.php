@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $discussion->title }}</h1>
        <p>Module: {{ $discussion->module->title }}</p>

        <h3>Comments</h3>
        @if ($discussion->comments->isEmpty())
            <p>No comments yet.</p>
        @else
            <ul class="list-group mb-3">
                @foreach ($discussion->comments as $comment)
                    <li class="list-group-item">
                        <strong>User ID {{ $comment->user_id }}:</strong>
                        {{ $comment->comment }}
                        <br>
                        <small>Posted at: {{ $comment->created_at->format('Y-m-d H:i') }}</small>

                        <!-- Replies -->
                        @if ($comment->replies->isNotEmpty())
                            <ul class="list-group mt-2">
                                @foreach ($comment->replies as $reply)
                                    <li class="list-group-item">
                                        <strong>Reply by User ID {{ $reply->user_id }}:</strong>
                                        {{ $reply->comment }}
                                        <br>
                                        <small>Posted at: {{ $reply->created_at->format('Y-m-d H:i') }}</small>
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                        <!-- Reply Form for Teachers -->
                        @if (auth()->user()->role === 'teacher')
                            <form method="POST" action="{{ route('teacher.comments.reply', $comment->id) }}" class="mt-2">
                                @csrf
                                <div class="mb-3">
                                    <textarea class="form-control" name="comment" rows="2" required placeholder="Write your reply..."></textarea>
                                </div>
                                <button type="submit" class="btn btn-sm btn-primary">Reply</button>
                            </form>
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
