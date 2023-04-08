<?php

namespace App\Http\Requests;

use App\Enums\Permissions;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class RoleRequest extends FormRequest
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

        if ($this->isMethod('POST')) {
            $onCreateRules = [
                'name' => ['bail', 'required', 'max:255', Rule::unique(config('permission.table_names')['roles'], 'name')],
            ];
        } elseif ($this->isMethod('PUT')) {
            /** @var Role $role */
            $role = $this->route('role');
            $onUpdateRules = [
                'name' => ['bail', 'required', 'max:255', Rule::unique(config('permission.table_names')['roles'], 'name')->ignoreModel($role)],
            ];
        }
        return [
            ...$onCreateRules,
            'permissions' => ['bail', 'required', 'array'],
            'permissions.*' => ['bail', 'required', Rule::exists(config('permission.table_names')['permissions'], 'id')],
            ...$onUpdateRules,
        ];
    }
}
