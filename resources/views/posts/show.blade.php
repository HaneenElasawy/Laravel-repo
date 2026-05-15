@extends('layouts.app')

@section('content')

<h1>Post Details</h1>

<div style="border:1px solid #ccc; padding:15px; margin-bottom:20px;">
    <h3>Post Info</h3>

    <p><strong>Title:</strong> {{ $post->title }}</p>
    <p><strong>Description:</strong> {{ $post->content }}</p>
    <p><strong>Created At:</strong> {{ $post->created_at->format('l d F Y h:i:s A') }}</p>
</div>

<div style="border:1px solid #ccc; padding:15px;">
    <h3>Post Creator Info</h3>

    <p><strong>Name:</strong> {{ $post->user?->name ?? 'Unknown' }}</p>
    <p><strong>Email:</strong> {{ $post->user?->email ?? 'No email' }}</p>
</div>

<br>

<a href="/posts">
    <x-button type="secondary">Back to All Posts</x-button>
</a>

@endsection
