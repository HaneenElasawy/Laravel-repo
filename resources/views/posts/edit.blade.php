@extends('layouts.app')

@section('content')

<h1>Edit Post</h1>

<form action="/posts/{{ $post->id }}" method="POST">
    @csrf
    @method('PUT')

    <label>Title</label><br>
    <input type="text" name="title" value="{{ $post->title }}">

    <br><br>

    <label>Content</label><br>
    <textarea name="content">{{ $post->content }}</textarea>

    <br><br>

    <button type="submit">Update</button>
</form>

@endsection
