@extends('layouts.app')

@section('content')

<h1>Create Post</h1>

<form action="/posts" method="POST">
    @csrf

    <label>Title</label><br>
    <input type="text" name="title">

    <br><br>

    <label>Content</label><br>
    <textarea name="content"></textarea>

    <br><br>

    <button type="submit">Submit</button>
</form>

@endsection
