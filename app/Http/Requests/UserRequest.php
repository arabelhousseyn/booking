<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserRequest extends FormRequest
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
        $onCreateRules = [];
        $onUpdateRules = [];

        if ($this->isMethod('post')) {
            $onCreateRules = [
                'email' => ['bail', 'required', 'email:rfc,dns,filter', Rule::unique('users', 'email')],
                'phone' => ['bail', 'required', 'digits:10', Rule::unique('users', 'phone')],
            ];
        } elseif ($this->isMethod('put')) {
            /** @var User $user */
            $user = $this->route('user');
            $onUpdateRules = [
                'email' => ['bail', 'required', 'email:rfc,dns,filter', Rule::unique('users', 'email')->ignoreModel($user)],
                'phone' => ['bail', 'required', 'digits:10', Rule::unique('users', 'phone')->ignoreModel($user)],
            ];
        }
        return [
            ...$onCreateRules,
            'first_name' => ['bail', 'required', 'max:255'],
            'last_name' => ['bail', 'required', 'max:255'],
            'country_code' => ['bail', 'required'],
            'password' => ['bail', 'required', 'sometimes', 'confirmed', Password::default()],
            ...$onUpdateRules,
        ];
    }
}
