<?php

namespace App\Http\Resources;

use App\Models\Doctor;
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
            'personal_data' => [
                'first_name' => $this->personalData->first_name,
                'last_name' => $this->personalData->last_name,
                'fullname' => $this->personalData->fullname,
                'phone' => $this->personalData->phone,
                'id_card' => $this->personalData->id_card,
                'email' => $this->personalData->email,
                'nationality' => $this->personalData->nationality,
                'gender' => $this->personalData->gender,
            ],
            'specialty' => [
                'id' => $this->specialty->id,
                'name' => $this->specialty->name,
            ],
            'metadata' => array_map(fn($m) => [
                'key' => $m['key'],
                'value' => $m['value'],
            ], $this->metadata->all()),
            'is_occupational_doctor' => $this->is_occupational_doctor,
        ];
    }
}
