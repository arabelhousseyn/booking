<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ResetPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'email' => ['bail', 'required', 'email:rfc,dns,filter', Rule::exists('users', 'email')],
            'token' => ['bail', 'required', 'max:60'],
            'password' => ['bail', 'required', 'confirmed', Password::default()],
        ];
    }
}
