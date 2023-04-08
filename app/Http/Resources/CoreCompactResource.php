<?php

namespace App\Http\Resources;

use App\Models\Core;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Core */
class CoreCompactResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'KM' => $this->KM,
        ];
    }
}
