<?php

namespace App\Http\Resources;

use App\Enums\ModelType;
use App\Models\Booking;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Booking */
class BookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
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
            'payment_type' => $this->payment_type,
            'net_price' => $this->net_price,
            'total_price' => $this->total_price,
            'has_caution' => $this->has_caution,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'status' => $this->status,
            'created_at' => $this->created_at->toISOString(),
        ];
    }
}
