<?php

namespace App\Http\Requests;

use App\Enums\PaymentStatus;
use App\Models\Booking;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookingPaymentStatusRequest extends FormRequest
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
        return $booking->payment_status->is(PaymentStatus::PENDING);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'payment_status' => ['bail', 'required', Rule::in([PaymentStatus::PAID])],
        ];
    }
}
