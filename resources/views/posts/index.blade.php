@extends('layouts.app')

@section('content')

@php
use Illuminate\Support\Str;
@endphp

<div class="container py-4">
    <h1>My Blog</h1>

    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Posts List</h2>
        <a href="/posts/create">
            <x-button type="success">Create Post</x-button>
        </a>
    </div>

    <table border="1" cellpadding="10" cellspacing="0" width="100%" class="table table-hover">
        <thead class="table-dark">
            <tr>
                <th width="5%">ID</th>
                <th width="10%">Image</th>
                <th width="35%">Title</th>
                <th width="15%">Posted By</th>
                <th width="15%">Created At</th>
                <th width="20%">Actions</th>
            </tr>
        </thead>

        @foreach($posts as $post)
            <tr style="{{ $post->trashed() ? 'background-color: #f8d7da; opacity: 0.7;' : '' }}">
                <td>{{ $post->id }}</td>
                <td>
                    @if($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" alt="Post Thumb" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                    @else
                        <div style="width: 50px; height: 50px; background: #eee; display: flex; align-items: center; justify-content: center; font-size: 10px; color: #999;">No Image</div>
                    @endif
                </td>
                <td>{{ Str::limit($post->title, 50) }}</td>
                <td><strong>{{ $post->user?->name ?? 'Unknown' }}</strong></td>
                <td>{{ $post->created_at->format('D d M Y') }}</td>

                <td>
                    <div style="display:flex; gap:5px;">
                        <a href="/posts/{{ $post->slug }}">
                            <x-button type="primary">View</x-button>
                        </a>

                        @if($post->trashed())
                            <form action="/posts/{{ $post->id }}/restore" method="POST" style="display:inline;">
                                @csrf
                                @method('PUT')
                                <x-button type="success" type="submit">Restore</x-button>
                            </form>
                        @else
                            <a href="/posts/{{ $post->slug }}/edit">
                                <x-button type="secondary">Edit</x-button>
                            </a>

                            <form action="/posts/{{ $post->slug }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this post?');">
                                @csrf
                                @method('DELETE')
                                <x-button type="danger" type="submit">Delete</x-button>
                            </form>
                        @endif
                    </div>
                </td>
            </tr>
        @endforeach
    </table>

    <br>

    @if ($posts->hasPages())
        <nav style="margin-top: 15px;">
            <ul class="pagination">
                @if ($posts->onFirstPage())
                    <li class="page-item disabled"><span class="page-link">Previous</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $posts->previousPageUrl() }}">Previous</a></li>
                @endif

                <li class="page-item disabled"><span class="page-link">Page {{ $posts->currentPage() }} of {{ $posts->lastPage() }}</span></li>

                @if ($posts->hasMorePages())
                    <li class="page-item"><a class="page-link" href="{{ $posts->nextPageUrl() }}">Next</a></li>
                @else
                    <li class="page-item disabled"><span class="page-link">Next</span></li>
                @endif
            </ul>
        </nav>
    @endif
</div>

@endsection
