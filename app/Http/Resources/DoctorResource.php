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
                'first_name' => $this->person->first_name,
                'last_name' => $this->person->last_name,
                'fullname' => $this->person->fullname,
                'phone' => $this->person->phone,
                'id_card' => $this->person->id_card,
                'email' => $this->person->user->email,
                'nationality' => $this->person->nationality,
                'gender' => $this->person->gender,
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
