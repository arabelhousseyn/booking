<?php

namespace App\Http\Requests;

use App\Enums\ModelType;
use App\Models\Booking;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBookingStateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        /** @var Booking $booking */
        $booking = $this->route('booking');
        return $booking->bookable_type == ModelType::VEHICLE;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'state' => ['bail', 'required', Rule::in(['start', 'end'])],
            'images' => ['bail', 'required', 'array'],
            'images.*' => ['bail', 'image', 'mimes:jpg,jpeg,png'],
        ];
    }
}
