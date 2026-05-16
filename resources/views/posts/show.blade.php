@extends('layouts.app')

@section('content')

<div class="container py-4">
    <h1>Post Details</h1>

    <div style="border:1px solid #ccc; padding:15px; margin-bottom:20px; border-radius: 8px;">
        <h3>Post Info</h3>
        <p><strong>Title:</strong> {{ $post->title }}</p>
        <p><strong>Description:</strong> {{ $post->content }}</p>
        <p><strong>Created At:</strong> {{ $post->created_at->format('l d F Y h:i:s A') }}</p>
    </div>

    <div style="border:1px solid #ccc; padding:15px; margin-bottom:20px; border-radius: 8px;">
        <h3>Post Creator Info</h3>
        <p><strong>Name:</strong> {{ $post->user?->name ?? 'Unknown' }}</p>
        <p><strong>Email:</strong> {{ $post->user?->email ?? 'No email' }}</p>
    </div>

    <hr>

    <div class="mt-4">
        <h3>Comments</h3>

        @forelse($post->comments as $comment)
            <div class="card mb-2 shadow-sm">
                <div class="card-body">
                    <p class="mb-1">{{ $comment->body }}</p>
                    <small class="text-muted">
                        By: <strong>{{ $comment->user?->name ?? 'Anonymous' }}</strong>
                        | {{ $comment->created_at->diffForHumans() }}
                    </small>
                </div>
            </div>
        @empty
            <p class="text-muted">No comments yet. Be the first to comment!</p>
        @endforelse

        <div class="card mt-4">
            <div class="card-header bg-light">
                <strong>Add a Comment</strong>
            </div>
            <div class="card-body">
                <form action="{{ route('comments.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="commentable_id" value="{{ $post->id }}">
                    <input type="hidden" name="commentable_type" value="App\Models\Post">

                    <div class="form-group mb-3">
                        <textarea name="body" class="form-control @error('body') is-invalid @enderror" rows="3" placeholder="What's on your mind?"></textarea>
                        @error('body')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Comment</button>
                </form>
            </div>
        </div>
    </div>

    <br>

    <a href="/posts">
        <x-button type="secondary">Back to All Posts</x-button>
    </a>
</div>

@endsection
