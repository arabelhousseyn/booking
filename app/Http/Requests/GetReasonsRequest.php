<?php

namespace App\Http\Requests;

use App\Enums\ReasonTypes;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetReasonsRequest extends FormRequest
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
            'type' => ['bail', 'required', Rule::in([ReasonTypes::VEHICLES, ReasonTypes::HOUSES])],
        ];
    }
}
