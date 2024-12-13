<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Discussion;
use App\Models\Module;

class DiscussionController extends Controller
{
    public function show($id)
    {
        // Find or create the discussion
        $discussion = Discussion::with([
            'module',
            'comments' => function ($query) {
                $query->whereNull('parent_id')->with(['replies.user', 'user']);
            },
        ])->find($id);

        if (!$discussion) {
            $module = Module::findOrFail($id);
            $discussion = $module->discussion()->create([
                'teacher_id' => $module->course->teacher_id,
                'title' => "Discussion for {$module->title}",
            ]);

            $discussion->load(['module', 'comments.replies.user', 'comments.user']);
        }

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
