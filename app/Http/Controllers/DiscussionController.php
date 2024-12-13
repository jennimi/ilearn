<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Discussion;

class DiscussionController extends Controller
{
    public function show($id)
    {
        $discussion = Discussion::with([
            'module', 
            'comments' => function ($query) {
                $query->whereNull('parent_id')->with(['replies.user', 'user']);
            },
        ])->findOrFail($id);

        return view('discussions.show', compact('discussion'));
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
