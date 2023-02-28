<?php

namespace App\Http\Resources;


use App\Enums\ModelType;
use App\Models\Favorite;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Favorite */
class UserFavoriteResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'favorable_type' => $this->favorable_type,
            'favorable_id' => $this->favorable_id,
            'favorable' => $this->whenLoaded('favorable',function (){
                return match ($this->favorable_type->value)
                {
                    ModelType::VEHICLE => VehicleResource::make($this->favorable),
                    ModelType::HOUSE => HouseResource::make($this->favorable),
                };
            })
        ];
    }
}
