<?php

namespace App\Http\Resources;

use App\Models\Reason;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Reason */
class ReasonCompactResource extends JsonResource
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
            'description' => $this->description,
        ];
    }
}
