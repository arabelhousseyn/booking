<?php

namespace App\Http\Requests;

use App\Enums\GearBox;
use App\Enums\Motorisation;
use App\Rules\Coordinates;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreVehicleRequest extends FormRequest
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
            'title' => ['bail', 'required', 'max:255'],
            'description' => ['bail', 'required'],
            'coordinates' => ['bail', 'required', new Coordinates()],
            'places' => ['bail', 'required', 'integer'],
            'price' => ['bail', 'required', 'numeric'],
            'motorisation' => ['bail', 'required', Rule::in(Motorisation::GAS, Motorisation::GASOLINE, Motorisation::DIESEL)],
            'gearbox' => ['bail', 'required', Rule::in(GearBox::MANUAL, GearBox::AUTOMATIC)],
            'is_full' => ['bail', 'required', 'boolean'],
            'payments_accepted' => ['bail', 'required', 'json'],
            'photos' => ['bail', 'required', 'array'],
            'photos.*' => ['bail', 'required', 'image', 'mimes:jpg,jpeg,png'],
        ];
    }
}
