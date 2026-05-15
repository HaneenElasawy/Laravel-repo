@extends('layouts.app')

@section('content')

@php
use Illuminate\Support\Str;
@endphp

<h1>My Blog</h1>

@if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif

<h2>Posts List</h2>

<a href="/posts/create">
    <x-button type="success">Create Post</x-button>
</a>

<br><br>

<table border="1" cellpadding="10" cellspacing="0" width="100%">
    <tr>
        <th width="7%">ID</th>
        <th width="40%">Title</th>
        <th width="20%">Posted By</th>
        <th width="15%">Created At</th>
        <th width="18%">Actions</th>
    </tr>

    @foreach($posts as $post)
        <tr>
            <td>{{ $post->id }}</td>
            <td>{{ Str::limit($post->title, 50) }}</td>
            <td>{{ $post->user?->name ?? 'Unknown' }}</td>
            <td>{{ $post->created_at->format('D d M Y') }}</td>

            <td style="display:flex; gap:5px;">
    <a href="/posts/{{ $post->id }}">
        <x-button type="primary">View</x-button>
    </a>

    @if($post->trashed())
        <form action="/posts/{{ $post->id }}/restore" method="POST" style="display:inline;">
            @csrf
            @method('PUT')
            <x-button type="success" type="submit">Restore</x-button>
        </form>
    @else
        <a href="/posts/{{ $post->id }}/edit">
            <x-button type="secondary">Edit</x-button>
        </a>

        <form action="/posts/{{ $post->id }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this post?');">
            @csrf
            @method('DELETE')
            <x-button type="danger" type="submit">Delete</x-button>
        </form>
    @endif
</td>
        </tr>
    @endforeach
</table>

<br>

@if ($posts->hasPages())
    <div style="margin-top: 15px;">
        @if ($posts->onFirstPage())
            <span>Previous</span>
        @else
            <a href="{{ $posts->previousPageUrl() }}">Previous</a>
        @endif

        <span style="margin: 0 10px;">
            Page {{ $posts->currentPage() }} of {{ $posts->lastPage() }}
        </span>

        @if ($posts->hasMorePages())
            <a href="{{ $posts->nextPageUrl() }}">Next</a>
        @else
            <span>Next</span>
        @endif
    </div>
@endif

@endsection
