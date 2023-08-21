<?php

namespace App\Http\Requests;

use App\Rules\Coordinates;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetPropertyRequest extends FormRequest
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
            'coordinates' => ['bail', 'nullable', Rule::requiredIf(!auth()->check()), new Coordinates()],
            'start_date' => ['bail', 'required', 'date'],
            'end_date' => ['bail', 'required', 'date', 'after:start_date'],
        ];
    }
}
