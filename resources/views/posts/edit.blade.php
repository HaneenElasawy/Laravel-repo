@extends('layouts.app')

@section('content')

<h1>Edit Post</h1>

<form action="/posts/{{ $post->id }}" method="POST">
    @csrf
    @method('PUT')

    <label>Title</label><br>
    <input type="text" name="title" value="{{ $post->title }}" style="width:100%;">

    <br><br>

    <label>Description</label><br>
    <textarea name="content" style="width:100%; height:100px;">{{ $post->content }}</textarea>

    <br><br>

    <label>Post Creator</label><br>
    <select name="user_id" style="width:100%;">
        @foreach($users as $user)
            <option value="{{ $user->id }}" @selected($post->user_id == $user->id)>
                {{ $user->name }}
            </option>
        @endforeach
    </select>

    <br><br>

    <x-button type="primary" type="submit">Update</x-button>
</form>

@endsection
