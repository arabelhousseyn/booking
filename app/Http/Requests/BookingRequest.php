<?php

namespace App\Http\Requests;

use App\Enums\ModelType;
use App\Enums\PaymentType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookingRequest extends FormRequest
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
            'bookable_type' => ['bail', 'required', Rule::in([ModelType::HOUSE, ModelType::VEHICLE])],
            'bookable_id' => ['bail', 'required', 'uuid', 'poly_exists:bookable_type'],
            'payment_type' => ['bail', 'required', Rule::in(PaymentType::DAHABIA, PaymentType::MASTER_CARD, PaymentType::VISA)],
            'start_date' => ['bail', 'required', 'date', 'date_format:Y-m-d H:i:s'],
            'end_date' => ['bail', 'required', 'date', 'date_format:Y-m-d H:i:s', 'after:start_date'],
        ];
    }
}
