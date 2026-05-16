@extends('layouts.app')

@section('content')

<div class="container py-4">
    <h1>Create Post</h1>

    <form action="/posts" method="POST" enctype="multipart/form-data">
        @csrf

        <label class="form-label">Title</label><br>
        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}">
        @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        <br>

        <label class="form-label">Description</label><br>
        <textarea name="content" class="form-control @error('content') is-invalid @enderror" style="height:100px;">{{ old('content') }}</textarea>
        @error('content')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        <br>

        <label class="form-label">Post Image</label><br>
        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
        @error('image')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        <br>

        <label class="form-label">Post Creator</label><br>
        <select name="user_id" class="form-select">
            @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>

        <br><br>

        <x-button type="success" type="submit">Create Post</x-button>
    </form>
</div>

@endsection
