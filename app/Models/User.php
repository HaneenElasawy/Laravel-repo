<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Post;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Sluggable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'slug',
        'image',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucfirst($value),
            set: fn ($value) => strtolower($value)
        );
    }

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? asset('storage/' . $value) : null
        );
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    protected static function booted()
    {
        static::deleting(function ($user) {
            if ($user->image) {
                $purePath = str_replace(asset('storage/'), '', $user->image);
                \Illuminate\Support\Facades\Storage::disk('public')->delete($purePath);
            }

            $user->posts()->each(function ($post) {
                if ($post->image) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($post->image);
                }
                $post->delete();
            });
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
