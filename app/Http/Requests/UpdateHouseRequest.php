<?php

namespace App\Http\Requests;

use App\Rules\Coordinates;
use Illuminate\Foundation\Http\FormRequest;

class UpdateHouseRequest extends FormRequest
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
            'price' => ['bail', 'sometimes', 'numeric'],
            'rooms' => ['bail', 'sometimes', 'integer'],
            'has_wifi' => ['bail', 'sometimes', 'boolean'],
            'parking_station' => ['bail', 'sometimes', 'boolean'],
            'photos' => ['bail', 'sometimes', 'array'],
            'photos.*' => ['bail', 'required', 'image', 'mimes:jpg,jpeg,png'],
        ];
    }
}
