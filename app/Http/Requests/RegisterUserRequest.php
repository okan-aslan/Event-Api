<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'min:5', 'string'],
            'email' => ['required', 'email', 'unique:users,email', 'string'],
            'password' => ['required', 'confirmed', 'min:8', 'max:255'],
        ];
    }
}
