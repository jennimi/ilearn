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
        // Load the discussion with the related module, course, teacher, and comments
        $discussion = Discussion::with([
            'module.course.teacher',
            'comments' => function ($query) {
                // Load only top-level comments
                $query->whereNull('parent_id')->with('user', 'replies.user');
            },
        ])->findOrFail($id);

        // Check if discussion doesn't exist, create one
        if (!$discussion) {
            $module = Module::findOrFail($id);

            $discussion = $module->discussion()->create([
                'teacher_id' => $module->course->teacher_id,
                'title' => "Discussion for {$module->title}",
            ]);

            // Reload the relationships after creating the discussion
            $discussion->load([
                'comments' => function ($query) {
                    $query->whereNull('parent_id')->with('user', 'replies.user');
                },
            ]);
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
