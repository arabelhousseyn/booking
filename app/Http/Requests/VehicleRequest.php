<?php

namespace App\Http\Requests;

use App\Enums\GearBox;
use App\Enums\Motorisation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VehicleRequest extends FormRequest
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
            'title' => ['bail', 'sometimes', 'max:255'],
            'description' => ['bail', 'sometimes'],
            'price' => ['bail', 'sometimes', 'numeric'],
            'places' => ['bail', 'sometimes', 'numeric'],
            'motorisation' => ['bail', 'sometimes', Rule::in(Motorisation::getValues())],
            'gearbox' => ['bail', 'sometimes', Rule::in(GearBox::getValues())],
        ];
    }
}
