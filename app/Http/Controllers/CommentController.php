<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'body' => 'required|min:3',
            'commentable_id' => 'required',
            'commentable_type' => 'required',
        ]);

        $modelClass = $request->commentable_type;
        $model = $modelClass::findOrFail($request->commentable_id);

        $model->comments()->create([
            'body' => $request->body,
            'user_id' => auth()->id() ?? 1,
        ]);

        return back()->with('success', 'Comment added successfully!');
    }
}
