<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\ForbiddenWords;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:50', new ForbiddenWords()],

            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($this->user->id)
            ],

            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique' => 'This email belongs to another account.',
            'password.confirmed' => 'The password confirmation does not match.',
            'image.max' => 'The image size should not exceed 2MB.',
        ];
    }
}
