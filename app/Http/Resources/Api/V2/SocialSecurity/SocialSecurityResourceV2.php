<?php

namespace App\Http\Resources\Api\V2\SocialSecurity;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SocialSecurityResourceV2 extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
