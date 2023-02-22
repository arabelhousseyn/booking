<?php

namespace App\Http\Requests;

use App\Rules\Coordinates;
use Illuminate\Foundation\Http\FormRequest;

class StoreHouseRequest extends FormRequest
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
            'price' => ['bail', 'required', 'numeric'],
            'rooms' => ['bail', 'required', 'integer'],
            'has_wifi' => ['bail', 'required', 'boolean'],
            'parking_station' => ['bail', 'required', 'boolean'],
            'photos' => ['bail', 'required', 'array'],
            'photos.*' => ['bail', 'required', 'image', 'mimes:jpg,jpeg,png'],
        ];
    }
}
