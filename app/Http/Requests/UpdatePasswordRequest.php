<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'current_password' => ['required', 'string'],
            'new_password'     => [
                'required',
                'string',
                'min:8',
                'confirmed',        // requires new_password_confirmation field
                'different:current_password',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'new_password.different'  => 'New password must be different from your current password.',
            'new_password.confirmed'  => 'Password confirmation does not match.',
            'new_password.min'        => 'Password must be at least 8 characters.',
        ];
    }
}