<?php

namespace App\Http\Requests;

use App\Rules\Coordinates;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserUpdateProfileRequest extends FormRequest
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
            'first_name' => ['bail', 'nullable', 'max:255'],
            'last_name' => ['bail', 'nullable', 'max:255'],
            'email' => ['bail', 'nullable', 'email:rfc,dns,filter', Rule::unique('users', 'email')->ignore(auth()->id())],
            'coordinates' => ['bail', 'nullable', new Coordinates()],
            'avatar' => ['bail', 'nullable', 'image', 'mimes:jpg,jpeg,png'],
            'rib_bank_account' => ['bail', 'nullable', 'string'],
            'dahabia_account' => ['bail', 'nullable', 'string'],
        ];
    }
}
