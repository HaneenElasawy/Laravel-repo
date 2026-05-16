@extends('layouts.app')

@section('content')
<div class="container py-5" style="max-width: 1000px; font-family: 'Inter', sans-serif;">

    <div class="d-flex justify-content-between align-items-end mb-4 pb-2" style="border-bottom: 2px solid #000;">
        <h2 style="font-weight: 800; text-transform: uppercase; letter-spacing: 2px; margin: 0;">User Directory</h2>
        <a href="{{ route('users.create') }}" class="btn btn-dark" style="border-radius: 0; padding: 10px 25px; font-size: 12px; font-weight: bold; letter-spacing: 1px;">
            + ADD NEW USER
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-dark" style="border-radius: 0; border-left: 5px solid #000; font-size: 13px; background-color: #f8f9fa;">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-hover" style="border-color: #eee;">
            <thead>
                <tr style="font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #888; border-bottom: 1px solid #000;">
                    <th class="border-0 px-3 py-3">ID</th>
                    <th class="border-0 py-3">Image</th>
                    <th class="border-0 py-3">Full Name</th>
                    <th class="border-0 py-3">Email Address</th>
                    <th class="border-0 py-3 text-end px-3">Management</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr style="vertical-align: middle; border-bottom: 1px solid #f0f0f0;">
                    <td class="text-muted px-3" style="font-size: 13px; font-family: 'Courier New', Courier, monospace;">
                        #{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}
                    </td>

                    <td class="py-2">
                        @if($user->image)
                            <img src="{{ $user->image }}"
                                alt="{{ $user->name }}"
                                style="width: 45px; height: 45px; object-fit: cover; border-radius: 50%; border: 1px solid #ddd;">
                        @else
                            <div style="width: 45px; height: 45px; border-radius: 50%; background-color: #eaeaea; color: #aaa; display: flex; align-items: center; justify-content: center; font-size: 10px; font-weight: bold; text-transform: uppercase;">
                                No Img
                            </div>
                        @endif
                    </td>

                    <td style="font-weight: 600; color: #000;">{{ $user->name }}</td>
                    <td style="color: #666; font-size: 14px;">{{ $user->email }}</td>
                    <td class="text-end px-3">
                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('users.edit', $user->slug) }}"
                            class="text-dark"
                            style="font-size: 11px; font-weight: 800; text-decoration: none; text-transform: uppercase; letter-spacing: 1px;">
                                Edit
                            </a>

                            <form action="{{ route('users.destroy', $user->slug) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure? This will delete all user posts and comments!')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="text-danger border-0 bg-transparent p-0"
                                        style="font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; cursor: pointer;">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-5 d-flex justify-content-center">
        {{ $users->links() }}
    </div>
</div>
@endsection
