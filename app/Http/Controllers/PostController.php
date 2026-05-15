<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::withTrashed()->with('user')->latest()->paginate(10);

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        $users = User::all();

        return view('posts.create', compact('users'));
    }

    public function store(Request $request)
    {
        Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => $request->user_id,
        ]);

        return redirect('/posts')->with('success', 'Post created successfully');
    }

    public function show(Post $post)
    {
        $post->load('user');

        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $users = User::all();

        return view('posts.edit', compact('post', 'users'));
    }

    public function update(Request $request, Post $post)
    {
        $post->update([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => $request->user_id,
        ]);

        return redirect('/posts')->with('success', 'Post updated successfully');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect('/posts')->with('success', 'Post deleted successfully');
    }

    public function restore($id)
    {
        $post = Post::withTrashed()->findOrFail($id);

        $post->restore();

        return redirect()->back()->with('success', 'Post restored successfully');
    }
}
