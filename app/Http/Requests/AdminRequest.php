<?php

namespace App\Http\Requests;

use App\Models\Admin;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class AdminRequest extends FormRequest
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
                'email' => ['bail', 'required', 'email:dns,filter', Rule::unique('admins', 'email')],
            ];
        } elseif ($this->isMethod('put')) {

            /** @var Admin $admin */
            $admin = $this->route('admin');

            $onUpdateRules = [
                'email' => ['bail', 'required', 'email:dns,filter', Rule::unique('admins', 'email')->ignoreModel($admin)],
            ];
        }

        return [
            ...$onCreateRules,
            'full_name' => ['bail', 'required', 'max:255'],
            'password' => ['bail', 'required', 'sometimes', 'confirmed', Password::default()],
            'role' => ['bail', 'required', Rule::exists('roles', 'name')],
            ...$onUpdateRules,
        ];
    }
}
