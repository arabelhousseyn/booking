<?php

namespace App\Http\Requests;

use App\Enums\ModelType;
use App\Enums\PaymentType;
use App\Models\House;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Relations\Relation;
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
        /** @var House|Vehicle $bookable */
        $bookable = Relation::$morphMap[$this->input('bookable_type')]::find($this->input('bookable_id'));
        return [
            'bookable_type' => ['bail', 'required', Rule::in([ModelType::HOUSE, ModelType::VEHICLE])],
            'bookable_id' => [
                'bail', 'required', 'uuid', 'poly_exists:bookable_type',
                Rule::unique('bookings')->where('user_id', auth()->id())->where('seller_id', $bookable->seller_id)->where('bookable_type', $this->input('bookable_type')),
            ],
            'payment_type' => ['bail', 'required', Rule::in(PaymentType::DAHABIA, PaymentType::MASTER_CARD, PaymentType::VISA)],
            'start_date' => ['bail', 'required', 'date', 'date_format:Y-m-d H:i:s'],
            'end_date' => ['bail', 'required', 'date', 'date_format:Y-m-d H:i:s', 'after:start_date'],
        ];
    }
}
