<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserLoginRequest extends FormRequest
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
            'email' => ['bail', 'nullable', 'email:rfc,dns,filter', Rule::requiredIf(blank($this->input('phone')))],
            'phone' => ['bail', 'nullable', 'digits:10', Rule::requiredIf(blank($this->input('email')))],
            'password' => ['bail', 'required', Password::default()],
        ];
    }
}
