<?php

namespace App\Http\Resources;

use App\Enums\ModelType;
use App\Models\Booking;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Booking */
class BookingListResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'bookable_type' => $this->bookable_type,
            'bookable_id' => $this->bookable_id,
            'bookable' => $this->whenLoaded('bookable', function () {
                return match ($this->bookable_type->value) {
                    ModelType::VEHICLE => VehicleResource::make($this->bookable),
                    ModelType::HOUSE => HouseResource::make($this->bookable),
                };
            }),
            'user' => $this->whenLoaded('user', UserResource::make($this->user)),
            'payment_type' => $this->payment_type,
            'original_price' => $this->original_price,
            'calculated_price' => $this->calculated_price,
            'to_be_paid' => $this->caution,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'status' => $this->status,
            'payment_status' => $this->payment_status,
            'payment_details' => $this->payment_details,
            'created_at' => $this->created_at->toISOString(),
        ];
    }
}
