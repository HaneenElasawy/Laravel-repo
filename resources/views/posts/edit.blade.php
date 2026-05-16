@extends('layouts.app')

@section('content')

<div class="container py-4">
    <h1>Edit Post</h1>

    <form action="/posts/{{ $post->slug }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label class="form-label">Title</label><br>
        <input type="text" name="title" class="form-control" value="{{ old('title', $post->title) }}" style="width:100%;">

        <br>

        <label class="form-label">Description</label><br>
        <textarea name="content" class="form-control" style="width:100%; height:100px;">{{ old('content', $post->content) }}</textarea>

        <br>

        
        @if($post->image)
            <div class="mb-3">
                <label class="form-label d-block">Current Image</label>
                <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" style="width: 150px; border-radius: 8px; border: 1px solid #eee;">
            </div>
        @endif

        <label class="form-label">Change Image (Optional)</label><br>
        <input type="file" name="image" class="form-control">
        <small class="text-muted">Leave empty to keep the current image.</small>

        <br><br>

        <label class="form-label">Post Creator</label><br>
        <select name="user_id" class="form-select" style="width:100%;">
            @foreach($users as $user)
                <option value="{{ $user->id }}" @selected($post->user_id == $user->id)>
                    {{ $user->name }}
                </option>
            @endforeach
        </select>

        <br><br>

        <x-button type="primary" type="submit">Update Post</x-button>
    </form>
</div>

@endsection
