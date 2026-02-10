<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'sip_number' => $this->sip_number,
            'name' => $this->name,
            'email' => $this->user?->email,
            'specialization' => $this->specialization,
            'is_active' => (bool) $this->is_active,
        ];
    }
}
