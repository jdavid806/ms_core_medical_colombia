<?php

namespace App\Http\Resources\Api\V1\CopaymentRule;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CopaymentRuleResource extends JsonResource
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
