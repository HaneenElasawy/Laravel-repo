@extends('layouts.app')

@section('content')
<div class="container py-5" style="max-width: 600px; font-family: 'Inter', sans-serif;">

    <div class="d-flex justify-content-between align-items-center mb-5 pb-2" style="border-bottom: 2px solid #000;">
        <div>
            <h2 style="font-weight: 800; text-transform: uppercase; letter-spacing: 2px; margin: 0;">Edit Profile</h2>
            <p class="text-muted mb-0" style="font-size: 13px; text-transform: lowercase; font-style: italic;">Refining details for: {{ $user->name }}</p>
        </div>

        <form action="{{ route('likes.toggle') }}" method="POST" class="d-inline">
            @csrf
            <input type="hidden" name="id" value="{{ $user->id }}">
            <input type="hidden" name="type" value="App\Models\User">
            <x-button type="{{ $user->likes->where('user_id', auth()->id())->count() ? 'primary' : 'secondary' }}" type="submit">
                {{ $user->likes->where('user_id', auth()->id())->count() ? 'Recommended' : 'Recommend' }}
                ({{ $user->likes->count() }})
            </x-button>
        </form>
    </div>

    <div class="card border-0 shadow-sm mb-5" style="border-radius: 0;">
        <div class="card-body p-4">
            <form action="{{ route('users.update', $user->slug) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="form-label" style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;">Full Name</label>
                    <input type="text" name="name" class="form-control shadow-none"
                        style="border-radius: 0; border-color: #eee; padding: 12px;"
                        value="{{ old('name', $user->name) }}">
                    @error('name') <small class="text-danger" style="font-size: 10px;">{{ $message }}</small> @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label" style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;">Email Address</label>
                    <input type="email" name="email" class="form-control shadow-none"
                        style="border-radius: 0; border-color: #eee; padding: 12px;"
                        value="{{ old('email', $user->email) }}">
                    @error('email') <small class="text-danger" style="font-size: 10px;">{{ $message }}</small> @enderror
                </div>

                <div class="mb-4 p-3 border" style="border-radius: 0; background-color: #fdfdfd;">
                    <label class="form-label" style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; display: block;">Profile Image</label>

                    @if($user->image)
                        <div class="mb-3">
                            <img src="{{ $user->image }}" width="100" height="100" style="border-radius: 50%; object-fit: cover; border: 1px solid #ddd;" class="img-thumbnail">
                        </div>
                    @else
                        <p class="text-muted mb-2" style="font-size: 12px;">No profile image uploaded.</p>
                    @endif

                    <input type="file" name="image" class="form-control shadow-none" style="border-radius: 0; border-color: #eee; font-size: 13px;">
                    @error('image') <small class="text-danger" style="font-size: 10px;">{{ $message }}</small> @enderror
                </div>

                <div class="d-flex gap-2 pt-2">
                    <button type="submit" class="btn btn-dark w-100"
                            style="border-radius: 0; font-weight: 800; font-size: 12px; letter-spacing: 1px; padding: 12px;">
                        SAVE CHANGES
                    </button>
                    <a href="{{ route('users.index') }}" class="btn btn-outline-secondary w-50"
                    style="border-radius: 0; font-weight: 800; font-size: 12px; letter-spacing: 1px; padding: 12px; border-color: #eee; color: #aaa;">
                        CANCEL
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="mt-5">
        <h4 style="font-weight: 800; text-transform: uppercase; letter-spacing: 1px; font-size: 16px; border-bottom: 1px solid #eee; padding-bottom: 10px;">Profile Notes</h4>

        @forelse($user->comments as $comment)
            <div class="py-3 d-flex justify-content-between align-items-start" style="border-bottom: 1px solid #f9f9f9;">
                <div>
                    <p class="mb-1" style="font-size: 14px; color: #333;">{{ $comment->body }}</p>
                    <small class="text-muted" style="font-size: 11px; text-transform: uppercase;">
                        By {{ $comment->user?->name ?? 'System' }} • {{ $comment->created_at->diffForHumans() }}
                    </small>
                </div>

                <form action="{{ route('likes.toggle') }}" method="POST" class="d-inline">
                    @csrf
                    <input type="hidden" name="id" value="{{ $comment->id }}">
                    <input type="hidden" name="type" value="App\Models\Comment">
                    <x-button type="{{ $comment->likes->where('user_id', auth()->id())->count() ? 'primary' : 'secondary' }}" type="submit" style="font-size: 10px; padding: 2px 10px;">
                        {{ $comment->likes->where('user_id', auth()->id())->count() ? 'Liked' : 'Like' }}
                        ({{ $comment->likes->count() }})
                    </x-button>
                </form>
            </div>
        @empty
            <p class="text-muted py-3" style="font-size: 13px;">No profile notes available.</p>
        @endforelse

        <div class="mt-4 p-4 border" style="border-radius: 0; background-color: #fafafa;">
            <form action="{{ route('comments.store') }}" method="POST">
                @csrf
                <input type="hidden" name="commentable_id" value="{{ $user->id }}">
                <input type="hidden" name="commentable_type" value="App\Models\User">

                <div class="mb-3">
                    <label class="form-label" style="font-size: 10px; font-weight: 700; text-transform: uppercase;">Add a Note</label>
                    <textarea name="body" class="form-control shadow-none" rows="2" style="border-radius: 0; border-color: #eee; font-size: 13px;"></textarea>
                    @error('body') <small class="text-danger" style="font-size: 10px;">{{ $message }}</small> @enderror
                </div>
                <button type="submit" class="btn btn-outline-dark btn-sm" style="border-radius: 0; font-weight: 700; font-size: 11px; padding: 8px 20px;">SUBMIT NOTE</button>
            </form>
        </div>
    </div>
</div>
@endsection
