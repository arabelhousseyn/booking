<?php

namespace App\Http\Resources;

use App\Enums\ModelType;
use App\Models\Booking;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    public function __construct(public Booking $booking, public mixed $satimPaymentRegistration)
    {
        parent::__construct($booking);
    }


    public function toArray($request): array
    {
        $satimResponse = [];

        if (!is_array($this->satimPaymentRegistration)) {
            $this->satimPaymentRegistration = [];
        }

        if (filled($this->satimPaymentRegistration)) {
            $satimResponse = $this->satimPaymentRegistration;
        }
        return [
            'id' => $this->booking->id,
            'bookable_type' => $this->booking->bookable_type,
            'bookable_id' => $this->booking->bookable_id,
            'bookable' => $this->whenLoaded('bookable', function () {
                return match ($this->booking->bookable_type->value) {
                    ModelType::VEHICLE => VehicleResource::make($this->booking->bookable),
                    ModelType::HOUSE => HouseResource::make($this->booking->bookable),
                };
            }),
            'payment_type' => $this->booking->payment_type,
            'original_price' => $this->booking->original_price,
            'calculated_price' => $this->booking->calculated_price,
            'to_be_paid' => $this->booking->caution,
            'start_date' => $this->booking->start_date,
            'end_date' => $this->booking->end_date,
            'status' => $this->booking->status,
            ...$satimResponse,
            'created_at' => $this->booking->created_at->toISOString(),
        ];
    }
}
