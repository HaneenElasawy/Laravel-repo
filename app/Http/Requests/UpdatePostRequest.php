<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $postId = $this->route('post');

        return [
            'title' => [
                'bail',
                'required',
                'string',
                'min:3',
                'max:255',
                Rule::unique('posts', 'title')->ignore($postId),
            ],
            'body' => ['required', 'string', 'min:10'],
            'user_id' => ['required', 'exists:users,id'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];
    }
}
