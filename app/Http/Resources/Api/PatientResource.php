<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
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
            'mrn' => $this->mrn,
            'name' => $this->name,
            'email' => $this->user?->email,
            'phone' => $this->phone,
            'identity_number' => $this->identity_number,
            'address' => $this->address,
            'birth_date' => $this->birth_date->format('Y-m-d'),
            'gender' => $this->gender,
            'blood_type' => $this->blood_type,
        ];
    }
}
