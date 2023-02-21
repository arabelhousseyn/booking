<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ResetPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $tableName = (filled($this->route('seller'))) ? 'sellers' : 'users';
        return [
            'email' => ['bail', 'required', 'email:rfc,dns,filter', Rule::exists($tableName, 'email')],
            'token' => ['bail', 'required', 'max:60'],
            'password' => ['bail', 'required', 'confirmed', Password::default()],
        ];
    }
}
