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

        $userId = auth()->id() ?? \App\Models\User::first()?->id;

        if (!$userId) {
        return back()->with('error', 'You must create at least one user to add comments.');
    }
    $modelClass = $request->commentable_type;
    $model = $modelClass::findOrFail($request->commentable_id);

    Comment::create([
        'body' => $request->body,
        'user_id' => $userId,
        'commentable_id' => $request->commentable_id,
        'commentable_type' => $request->commentable_type,
    ]);

    return back()->with('success', 'Comment added successfully!');
}
}
