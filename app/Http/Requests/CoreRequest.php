<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CoreRequest extends FormRequest
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
            'commission' => ['bail','required','sometimes','numeric'],
            'KM' => ['bail','required','sometimes','numeric'],
            'vehicle_dahabia_caution' => ['bail','required','sometimes','numeric'],
            'vehicle_debit_card_caution' => ['bail','required','sometimes','numeric'],
            'house_dahabia_caution' => ['bail','required','sometimes','numeric'],
            'house_debit_card_caution' => ['bail','required','sometimes','numeric'],
        ];
    }
}
