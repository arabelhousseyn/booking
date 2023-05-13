<?php

namespace App\Http\Requests;

use App\Enums\BookingStatus;
use App\Models\Booking;
use Illuminate\Foundation\Http\FormRequest;

class TerminateBookingRequest extends FormRequest
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
        return $booking->status->is(BookingStatus::ACCEPTED);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'note' => ['bail', 'nullable', 'string'],
            'images' => ['bail', 'nullable', 'array'],
            'images.*' => ['bail', 'image', 'mimes:jpg,jpeg,png'],
        ];
    }
}
