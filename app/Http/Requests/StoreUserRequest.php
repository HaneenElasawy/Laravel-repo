<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * Set to true to allow the request to proceed.
     */
    public function authorize(): bool
    {
        // Must be true to allow the validation to run
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
            // User name must be a string with a length between 3 and 50 characters
            'name' => ['required', 'string', 'min:3', 'max:50'],

            // Email must be valid and unique in the users table
            'email' => ['required', 'email', 'unique:users,email'],

            // Password must be at least 8 characters and match the password_confirmation field
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    /**
     * Custom error messages for validation.
     * (Optional but good for professional practice)
     */
    public function messages(): array
    {
        return [
            'email.unique' => 'This email is already registered in our system.',
            'password.confirmed' => 'The password confirmation does not match.',
        ];
    }
}
