<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin User*/
class UserResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'can_rent_house' => $this->can_rent_house,
            'can_rent_vehicle' => $this->can_rent_vehicle,
            'validated' => $this->validated,
            'avatar' => $this->avatar,
            'token' => $this->token,
        ];
    }
}
