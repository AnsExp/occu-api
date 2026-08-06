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
                'first_name' => $this->person->first_name,
                'last_name' => $this->person->last_name,
                'fullname' => $this->person->fullname,
                'phone' => $this->person->phone,
                'id_card' => $this->person->id_card,
                'email' => $this->person->user->email,
                'nationality' => $this->person->nationality,
                'gender' => $this->person->gender,
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
