<?php

namespace App\Http\Resources;

use App\Models\Vehicle;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Vehicle */
class VehicleResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'places' => $this->places,
            'motorisation' => $this->motorisation,
            'price' => $this->price,
            'gearbox' => $this->gearbox,
            'is_full' => $this->is_full,
            'payments_accepted' => $this->payments_accepted,
            'status' => $this->status,
            'photo' => $this->photo,
            'photo_thumb' => $this->photo_thumb,
            'photos' => $this->photos,
        ];
    }
}
