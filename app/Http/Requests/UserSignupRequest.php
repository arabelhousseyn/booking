<?php

namespace App\Http\Requests;

use App\Rules\Coordinates;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserSignupRequest extends FormRequest
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
            'first_name' => ['bail', 'required', 'max:255'],
            'last_name' => ['bail', 'required', 'max:255'],
            'email' => ['bail', 'required', 'email:rfc,dns,filter', Rule::unique('users', 'email')],
            'phone' => ['bail', 'required', 'digits:10', Rule::unique('users', 'phone')],
            'country_code' => ['bail', 'required'],
            'coordinates' => ['bail', 'required', new Coordinates()],
            'password' => ['bail', 'required', Password::default()],
            'avatar' => ['bail', 'nullable', 'image', 'mimes:jpg,jpeg,png'],
            'firebase_registration_token' => ['bail', 'required'],
        ];
    }
}
