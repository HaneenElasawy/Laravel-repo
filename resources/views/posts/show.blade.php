@extends('layouts.app')

@section('content')

<h1>Post Details</h1>

<h2>{{ $post->title }}</h2>

<p>{{ $post->content }}</p>

<a href="/posts">Back to All Posts</a>

@endsection
