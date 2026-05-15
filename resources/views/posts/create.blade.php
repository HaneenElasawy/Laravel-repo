@extends('layouts.app')

@section('content')

<h1>Create Post</h1>

<form action="/posts" method="POST">
    @csrf

    <label>Title</label><br>
    <input type="text" name="title" style="width:100%;">

    <br><br>

    <label>Description</label><br>
    <textarea name="content" style="width:100%; height:100px;"></textarea>

    <br><br>

    <label>Post Creator</label><br>
    <select name="user_id" style="width:100%;">
        @foreach($users as $user)
            <option value="{{ $user->id }}">{{ $user->name }}</option>
        @endforeach
    </select>

    <br><br>

    <x-button type="success" type="submit">Create</x-button>
</form>

@endsection
