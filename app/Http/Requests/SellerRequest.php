<?php

namespace App\Http\Requests;

use App\Models\Seller;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class SellerRequest extends FormRequest
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
                'email' => ['bail', 'required', 'email:rfc,dns,filter', Rule::unique('sellers', 'email')],
                'phone' => ['bail', 'required', 'digits:10', Rule::unique('sellers', 'phone')],
            ];
        } elseif ($this->isMethod('put')) {
            /** @var Seller $seller */
            $seller = $this->route('seller');
            $onUpdateRules = [
                'email' => ['bail', 'required', 'email:rfc,dns,filter', Rule::unique('sellers', 'email')->ignoreModel($seller)],
                'phone' => ['bail', 'required', 'digits:10', Rule::unique('sellers', 'phone')->ignoreModel($seller)],
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
