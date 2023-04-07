<?php

namespace App\Http\Requests;

use App\Enums\ReasonTypes;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReasonRequest extends FormRequest
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
            'description' => ['bail', 'required', 'sometimes'],
            'type' => ['bail', 'required', 'sometimes', Rule::in([ReasonTypes::ALL, ReasonTypes::HOUSES, ReasonTypes::VEHICLES])],
        ];
    }
}
