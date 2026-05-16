<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * Set to true to allow the update request to proceed.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // User name must be a string between 3 and 50 characters
            'name' => ['required', 'string', 'min:3', 'max:50'],

            // Email must be valid and unique, excluding the current user's ID
            'email' => [
                'required',
                'email',
                'unique:users,email,' . $this->user->id
            ],

            // Password is optional during update; if provided, it must be at least 8 characters
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ];
    }

    /**
     * Custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'email.unique' => 'This email address is already taken by another user.',
            'password.confirmed' => 'The password confirmation does not match.',
        ];
    }
}
