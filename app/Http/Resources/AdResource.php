<?php

namespace App\Http\Resources;

use App\Models\Ad;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Ad */
class AdResource extends JsonResource
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
            'photos' => $this->photos,
        ];
    }
}
