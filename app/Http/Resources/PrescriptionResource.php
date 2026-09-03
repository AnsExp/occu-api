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
                    'fullname' => $this->doctor->personalData->fullname,
                ]
            ] : null,
            'patient' => $this->patient ? [
                'id' => $this->patient->id,
                'personal_data' => [
                    'fullname' => $this->patient->personalData->fullname,
                ]
            ] : null,
            'notes' => $this->notes,
            'medications' => array_map(fn($medication) => [
                'id' => $medication->medication->id,
                'name' => $medication->name,
                'price' => $medication->price,
                'quantity' => $medication->quantity,
                'notes' => $medication->notes,
            ], $this->medications->all()),
            'documents' => array_map(fn($document) => DocumentResource::make($document), $this->documents->all()),
            'document' => $this->latestDocument ? DocumentResource::make($this->latestDocument) : null,
            'timezone' => $this->timezone,
            'created_at' => $this->created_at,
        ];
    }
}
