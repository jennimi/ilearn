@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $discussion->title }} | {{ $discussion->module->course->title }}</h1>
        <p>Module: {{ $discussion->module->title }}</p>

        <h3>Comments</h3>
        @if ($discussion->comments->isEmpty())
            <p>No comments yet.</p>
        @else
            <ul class="list-group mb-3">
                @foreach ($discussion->comments as $comment)
                    <li class="list-group-item">
                        <strong>{{ $comment->user->name }}:</strong> <!-- Display the user's name -->
                        {{ $comment->comment }}
                        <br>
                        <small>Posted at: {{ $comment->created_at->format('Y-m-d H:i') }}</small>

                        <!-- Replies Section -->
                        @if ($comment->replies->isNotEmpty())
                            <button class="btn btn-link btn-sm mt-2" type="button" data-bs-toggle="collapse"
                                data-bs-target="#replies{{ $comment->id }}" aria-expanded="false"
                                aria-controls="replies{{ $comment->id }}">
                                View Replies ({{ $comment->replies->count() }})
                            </button>

                            <div class="collapse mt-2" id="replies{{ $comment->id }}">
                                <ul class="list-group">
                                    @foreach ($comment->replies as $reply)
                                        <li class="list-group-item">
                                            <strong>{{ $reply->user->name }}:</strong> <!-- Display the reply user's name -->
                                            {{ $reply->comment }}
                                            <br>
                                            <small>Posted at: {{ $reply->created_at->format('Y-m-d H:i') }}</small>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Reply Form for Teachers -->
                        @if (auth()->user()->role === 'teacher')
                            <form method="POST" action="{{ route('teacher.comments.reply', $comment->id) }}" class="mt-2">
                                @csrf
                                <div class="mb-3">
                                    <textarea class="form-control" name="comment" rows="2" required
                                        placeholder="Write your reply..."></textarea>
                                </div>
                                <button type="submit" class="btn btn-sm btn-primary">Reply</button>
                            </form>
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif

        <!-- Add Comment Form for Students -->
        @if (auth()->user()->role === 'student')
            <h4>Add a Comment</h4>
            <form method="POST" action="{{ route('discussions.comment.store', $discussion->id) }}">
                @csrf
                <div class="mb-3">
                    <textarea class="form-control" name="comment" rows="3" required
                        placeholder="Write your comment..."></textarea>
                </div>
                <button type="submit" class="btn btn-success">Post Comment</button>
            </form>
        @endif
    </div>
@endsection
