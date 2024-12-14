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
        $module = Module::with(['course.teacher', 'discussion.comments.replies.user', 'discussion.comments.user'])
            ->findOrFail($id);

        // Check if the discussion exists, create if it doesn't
        if (!$module->discussion) {
            $module->discussion()->create([
                'teacher_id' => $module->course->teacher_id,
                'title' => "Discussion for {$module->title}",
            ]);

            // Reload the discussion relationship
            $module->load('discussion.comments.replies.user', 'discussion.comments.user');
        }

        $discussion = $module->discussion;

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
