<?php

namespace App\Http\Resources;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Vehicle */
class VehicleResource extends JsonResource
{
    public function toArray($request): array
    {
        if (filled($request->start_date) && filled($request->end_date)) {
            $data = [
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'bookable_id' => $this->getKey(),
                'bookable_type' => $this->getMorphClass(),
            ];
            $price = round(User::calculatePrice($data), 2);
        } else {
            $price = $this->price;
        }
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'places' => $this->places,
            'motorisation' => $this->motorisation,
            'price' => $price,
            'gearbox' => $this->gearbox,
            'is_full' => $this->is_full,
            'payments_accepted' => $this->payments_accepted,
            'availability_start_date' => $this->availability_start_date,
            'availability_end_date' => $this->availability_end_date,
            'status' => $this->status,
            'coordinates' => $this->coordinates,
            'photo' => $this->photo,
            'photo_thumb' => $this->photo_thumb,
            'photos' => $this->photos,
            'avg_rating' => $this->reviews()->avg('rating'),
            'created_at' => $this->created_at?->toISOString(),
        ];
    }
}
