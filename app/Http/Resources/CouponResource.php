<?php

namespace App\Http\Resources;

use App\Models\Coupon;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Coupon */
class CouponResource extends JsonResource
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
            'code' => $this->code,
            'description' => $this->description,
            'value_type' => $this->value_type,
            'value' => $this->value,
            'type' => $this->type,
            'system_type' => $this->system_type,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'usage_limit' => $this->usage_limit,
        ];
    }
}
