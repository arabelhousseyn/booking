<?php

namespace App\Http\Resources;

use App\Models\House;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin House */
class HouseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
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
            'price' => $price,
            'rooms' => $this->rooms,
            'has_wifi' => $this->has_wifi,
            'parking_station' => $this->parking_station,
            'coordinates' => $this->coordinates,
            'availability_start_date' => $this->availability_start_date,
            'availability_end_date' => $this->availability_end_date,
            'status' => $this->status,
            'photo' => $this->photo,
            'photo_thumb' => $this->photo_thumb,
            'photos' => $this->photos,
            'avg_rating' => $this->reviews()->avg('rating'),
            'created_at' => $this->created_at?->toISOString(),
        ];
    }
}
