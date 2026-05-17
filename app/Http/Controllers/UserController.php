<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(StoreUserRequest $request)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'slug' => Str::slug($request->name),
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('users_images', 'public');
        }

        User::create($data);

        return redirect()->route('users.index')->with('success', 'User added successfully!');
    }

    public function show(User $user)
    {
        $user->load(['posts', 'comments.user', 'likes', 'comments.likes']);
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $user->load(['comments.user', 'likes', 'comments.likes']);
        return view('users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ];

        if ($request->hasFile('image')) {
            if ($user->getRawOriginal('image')) {
                Storage::disk('public')->delete($user->getRawOriginal('image'));
            }
            $data['image'] = $request->file('image')->store('users_images', 'public');
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }

    public function destroy(User $user)
    {
        if ($user->getRawOriginal('image')) {
            Storage::disk('public')->delete($user->getRawOriginal('image'));
        }

        $user->delete();

        return back()->with('success', 'User and all related data deleted permanently!');
    }
}
