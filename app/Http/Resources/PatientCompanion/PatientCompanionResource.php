<?php

namespace App\Http\Resources\PatientCompanion;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientCompanionResource extends JsonResource
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
