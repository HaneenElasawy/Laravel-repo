<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $data = $request->validate([
            'title' => 'required|min:3',
            'content' => 'required',
            'user_id' => 'required|exists:users,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('posts_images', 'public');
        }

        Post::create($data);

        return redirect('/posts')->with('success', 'Post created successfully');
    }

    public function show(Post $post)
    {
        $post->load(['user', 'comments.user', 'likes']);
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $users = User::all();
        return view('posts.edit', compact('post', 'users'));
    }

    public function update(Request $request, Post $post)
    {
        $data = $request->validate([
            'title' => 'required|min:3',
            'content' => 'required',
            'user_id' => 'required|exists:users,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $data['image'] = $request->file('image')->store('posts_images', 'public');
        }

        $post->update($data);

        return redirect('/posts')->with('success', 'Post updated successfully');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect('/posts')->with('success', 'Post soft deleted successfully');
    }

    public function restore($id)
    {
        $post = Post::withTrashed()->findOrFail($id);
        $post->restore();
        return redirect()->back()->with('success', 'Post restored successfully');
    }

    public function forceDelete($id)
    {
        $post = Post::withTrashed()->findOrFail($id);

        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->forceDelete();

        return redirect()->back()->with('success', 'Post and image permanently deleted');
    }

    public function toggleLike(Request $request)
    {
        $like = \App\Models\Like::where([
            'user_id' => auth()->id(),
            'likeable_id' => $request->id,
            'likeable_type' => $request->type,
        ])->first();

        if ($like) {
            $like->delete();
        } else {
            \App\Models\Like::create([
                'user_id' => auth()->id(),
                'likeable_id' => $request->id,
                'likeable_type' => $request->type,
            ]);
        }

        return back();
    }
}
