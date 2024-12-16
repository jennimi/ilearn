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
        $discussion = Discussion::with(['module.course.teacher', 'comments.replies.user', 'comments.user'])
        ->findOrFail($id);

        if (!$discussion) {
            // Assuming you want to create a new discussion related to a module
            $module = Module::findOrFail($discussion->module_id); // Get the related module
    
            $discussion = $module->discussion()->create([
                'teacher_id' => $module->course->teacher_id,
                'title' => "Discussion for {$module->title}",
            ]);
    
            // Reload the relationships after creating the discussion
            $discussion->load('comments.replies.user', 'comments.user');
            $discussion = $module->discussion;
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
