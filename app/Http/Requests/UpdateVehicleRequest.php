<?php

namespace App\Http\Requests;

use App\Enums\GearBox;
use App\Enums\Motorisation;
use App\Rules\Coordinates;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateVehicleRequest extends FormRequest
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
            'coordinates' => ['bail', 'sometimes', new Coordinates()],
            'places' => ['bail', 'sometimes', 'integer'],
            'price' => ['bail', 'sometimes', 'numeric'],
            'motorisation' => ['bail', 'sometimes', Rule::in(Motorisation::GAS, Motorisation::GASOLINE, Motorisation::DIESEL)],
            'gearbox' => ['bail', 'sometimes', Rule::in(GearBox::MANUAL, GearBox::AUTOMATIC)],
            'is_full' => ['bail', 'sometimes', 'boolean'],
            'payments_accepted' => ['bail', 'sometimes', 'json'],
            'photos' => ['bail', 'sometimes', 'array'],
            'photos.*' => ['bail', 'required', 'image', 'mimes:jpg,jpeg,png'],
        ];
    }
}
