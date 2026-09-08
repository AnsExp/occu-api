<?php

namespace App\Http\Resources;

use App\Models\LaboratoryOrder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LaboratoryOrderResource extends JsonResource
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
            'timezone' => $this->timezone,
            'created_at' => $this->created_at,
            'patient' => PatientResource::make($this->patient),
            'doctor' => $this->doctor ? DoctorResource::make($this->doctor) : null,
            'documents' => array_map(fn($document) => DocumentResource::make($document), $this->documents->all()),
            'document' => $this->latestDocument ? DocumentResource::make($this->latestDocument) : null,
            'exams' => array_map(fn($exam) => [
                'id' => $exam->id,
                'name' => $exam->laboratoryOption->name,
                'price' => $exam->laboratoryOption->price,
                'quantity' => $exam->quantity,
            ], $this->laboratoryExams->all())
        ];
    }
}
