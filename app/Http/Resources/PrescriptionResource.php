<?php

namespace App\Http\Resources;

use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PrescriptionResource extends JsonResource
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
            'code' => $this->code,
            'doctor' => $this->doctor ? [
                'id' => $this->doctor->id,
                'personal_data' => [
                    'fullname' => $this->doctor->person->fullname,
                ]
            ] : null,
            'patient' => $this->patient ? [
                'id' => $this->patient->id,
                'personal_data' => [
                    'fullname' => $this->patient->person->fullname,
                ]
            ] : null,
            'notes' => $this->notes,
            'medications' => array_map(fn($medication) => [
                'id' => $medication->medication->id,
                'name' => $medication->medication->name,
                'quantity' => $medication->quantity,
                'notes' => $medication->notes,
            ], $this->medications->all()),
            'created_at' => $this->created_at->setTimezone($this->timezone)->translatedFormat('Y-m-d H:i:s'),
        ];
    }
}
