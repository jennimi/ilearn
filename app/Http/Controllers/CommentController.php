<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Discussion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function reply(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string',
        ]);

        $parentComment = Comment::findOrFail($id);

        $parentDiscussion = $parentComment->discussion;

        $parentComment->replies()->create([
            'user_id' => Auth::id(),
            'discussion_id' => $parentDiscussion->id,
            'comment' => $request->input('comment'),
        ]);

        return redirect()->back()->with('success', 'Reply added successfully!');
    }

    public function addComment(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string',
        ]);

        $discussion = Discussion::findOrFail($id);

        $discussion->comments()->create([
            'user_id' => Auth::id(),
            'comment' => $request->input('comment'),
        ]);

        return redirect()->route('discussions.show', $id)->with('success', 'Comment added successfully!');
    }
}
