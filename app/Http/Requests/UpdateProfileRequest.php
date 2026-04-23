<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'          => ['required', 'string', 'max:255'],
            'email'         => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore(Auth::id()),
            ],
            // Member fields — only required when user has a linked member record
            'first_name'    => ['nullable', 'string', 'max:100'],
            'last_name'     => ['nullable', 'string', 'max:100'],
            'phone_number'    => ['nullable', 'string', 'max:20'],
            'date_of_birth'   => ['nullable', 'date', 'before:today'],
            'profile_picture' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique'         => 'This email is already taken by another account.',
            'date_of_birth.before' => 'Date of birth must be in the past.',
        ];
    }
}