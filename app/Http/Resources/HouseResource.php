<?php

namespace App\Http\Resources;

use App\Models\House;
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
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'rooms' => $this->rooms,
            'has_wifi' => $this->has_wifi,
            'parking_station' => $this->parking_station,
            'coordinates' => $this->coordinates,
            'status' => $this->status,
            'photo' => $this->photo,
            'photo_thumb' => $this->photo_thumb,
            'photos' => $this->photos,
            'avg_rating' => $this->reviews()->avg('rating'),
            'created_at' => $this->created_at?->toISOString()
        ];
    }
}
