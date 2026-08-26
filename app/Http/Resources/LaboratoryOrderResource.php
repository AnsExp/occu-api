<?php

namespace App\Http\Resources;

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
            'sha256' => $this->document->sha256,
            'timezone' => $this->timezone,
            'patient' => PatientResource::make($this->patient),
            'exams' => array_map(fn($exam) => [
                'id' => $exam->id,
                'name' => $exam->laboratoryOption->name,
                'price' => $exam->laboratoryOption->price,
                'quantity' => $exam->quantity,
            ], $this->laboratoryExams->all())
        ];
    }
}
