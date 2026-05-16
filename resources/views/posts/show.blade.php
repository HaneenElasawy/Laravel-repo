@extends('layouts.app')

@section('content')

<div class="container py-4" style="font-family: 'Inter', sans-serif;">
    <h1 style="font-weight: 800; text-transform: uppercase; letter-spacing: 1px;">Post Details</h1>

    {{-- Post Info Section --}}
    <div style="border:1px solid #eee; padding:25px; margin-bottom:20px; border-radius: 0; background: #fff; box-shadow: 0 2px 10px rgba(0,0,0,0.02);">
        @if($post->image)
            <div class="mb-4 text-center">
                <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" style="max-width: 100%; height: auto; border-radius: 4px;">
            </div>
        @endif

        <h3 style="font-weight: 700;">{{ $post->title }}</h3>
        <p class="text-muted" style="line-height: 1.8;">{{ $post->content }}</p>
        <hr>
        <div class="d-flex justify-content-between align-items-center">
            <small class="text-muted">Published on: {{ $post->created_at->format('l d F Y') }}</small>

            {{-- Like Button for Post --}}
            <form action="{{ route('likes.toggle') }}" method="POST" class="d-inline">
                @csrf
                <input type="hidden" name="id" value="{{ $post->id }}">
                <input type="hidden" name="type" value="App\Models\Post">
                <x-button type="{{ $post->likes->where('user_id', auth()->id())->count() ? 'primary' : 'secondary' }}">
                    {{ $post->likes->where('user_id', auth()->id())->count() ? 'Liked' : 'Like' }}
                    ({{ $post->likes->count() }})
                </x-button>
            </form>
        </div>
    </div>

    {{-- Creator Info --}}
    <div style="border:1px solid #eee; padding:15px; margin-bottom:20px; border-radius: 0; background: #fafafa;">
        <h5 style="font-size: 14px; font-weight: 800; text-transform: uppercase;">Author Info</h5>
        <p class="mb-1"><strong>Name:</strong> {{ $post->user?->name ?? 'Unknown' }}</p>
        <p class="mb-0"><strong>Email:</strong> {{ $post->user?->email ?? 'No email' }}</p>
    </div>

    <hr>

    {{-- Comments Section --}}
    <div class="mt-4">
        <h3 style="font-weight: 800; font-size: 18px;">COMMENTS</h3>

        @forelse($post->comments as $comment)
            <div class="card mb-3 shadow-none border-0" style="background: #fdfdfd; border-left: 3px solid #000 !important; padding-left: 10px;">
                <div class="card-body py-2">
                    <p class="mb-1" style="font-size: 15px;">{{ $comment->body }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            By <strong>{{ $comment->user?->name ?? 'Anonymous' }}</strong> • {{ $comment->created_at->diffForHumans() }}
                        </small>

                        {{-- Like Button for Comment (Morph) --}}
                        <form action="{{ route('likes.toggle') }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="id" value="{{ $comment->id }}">
                            <input type="hidden" name="type" value="App\Models\Comment">
                            <x-button type="{{ $comment->likes->where('user_id', auth()->id())->count() ? 'primary' : 'secondary' }}" style="font-size: 10px; padding: 2px 10px;">
                                {{ $comment->likes->where('user_id', auth()->id())->count() ? 'Liked' : 'Like' }}
                                ({{ $comment->likes->count() }})
                            </x-button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted italic">No thoughts shared yet.</p>
        @endforelse

        {{-- Add Comment Form --}}
        <div class="card mt-4 border-0 shadow-sm" style="border-radius: 0;">
            <div class="card-header bg-dark text-white" style="border-radius: 0; font-size: 12px; font-weight: 800; letter-spacing: 1px;">
                ADD A COMMENT
            </div>
            <div class="card-body">
                <form action="{{ route('comments.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="commentable_id" value="{{ $post->id }}">
                    <input type="hidden" name="commentable_type" value="App\Models\Post">

                    <div class="form-group mb-3">
                        <textarea name="body" class="form-control shadow-none @error('body') is-invalid @enderror" rows="3" style="border-radius: 0; border-color: #eee;"></textarea>
                        @error('body')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-dark" style="border-radius: 0; font-weight: 800; font-size: 12px; padding: 10px 25px;">SUBMIT</button>
                </form>
            </div>
        </div>
    </div>

    <br>
    <a href="/posts" class="text-decoration-none text-dark" style="font-size: 12px; font-weight: 700; letter-spacing: 1px;">← BACK TO BLOG</a>
</div>

@endsection
