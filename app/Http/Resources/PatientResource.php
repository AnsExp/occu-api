<?php

namespace App\Http\Resources;

use App\Models\Patient;
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
            'personal_data' => [
                'first_name' => $this->personalData->first_name,
                'last_name' => $this->personalData->last_name,
                'fullname' => $this->personalData->fullname,
                'phone' => $this->personalData->phone,
                'id_card' => $this->personalData->id_card,
                'email' => $this->personalData->email,
                'nationality' => $this->personalData->nationality,
                'gender' => $this->personalData->gender,
                'birth_date' => $this->personalData->birth_date,
            ],
            'agreement' => $this->agreement ? [
                'id' => $this->agreement->id,
                'institution' => $this->agreement->institution,
                'discount_type' => $this->agreement->discount_type,
                'discount_amount' => $this->agreement->discount_amount,
            ] : null,
            'metadata' => array_map(fn($m) => [
                'key' => $m['key'],
                'value' => $m['value'],
            ], $this->metadata->all()),
        ];
    }
}
