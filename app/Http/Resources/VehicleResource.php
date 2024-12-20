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

        $favorite = [];
        if(auth()->user()?->getMorphClass() == User::class)
        {
            $favorite = [
                'is_favorite' => auth()->user()?->favorites()?->where('favorable_type', '=', $this->getMorphClass())->where('favorable_id', '=', $this->getKey())->exists(),
                'favorite_id' => auth()->user()?->favorites()?->where('favorable_type', '=', $this->getMorphClass())->where('favorable_id', '=', $this->getKey())->exists() ?
                    auth()->user()?->favorites()->where('favorable_type', '=', $this->getMorphClass())->where('favorable_id', '=', $this->getKey())->first()->id : null,
            ];
        }

        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'places' => $this->places,
            'motorisation' => $this->motorisation,
            'price' => $price,
            'is_uploaded_documents' => $this->is_uploaded_documents,
            'gearbox' => $this->gearbox,
            'is_full' => $this->is_full,
            'payments_accepted' => $this->payments_accepted,
            'availability_start_date' => $this->availability_start_date,
            'availability_end_date' => $this->availability_end_date,
            'status' => $this->status,
            'coordinates' => $this->coordinates,
            'photo' => $this->photo,
            'photo_thumb' => $this->photo_thumb,
            'seller' => $this->whenLoaded('seller', SellerResource::make($this->seller)),
            'photos' => $this->photos,
            'avg_rating' => $this->reviews()->avg('rating'),
            ...$favorite,
            'created_at' => $this->created_at?->toISOString(),
        ];
    }
}
