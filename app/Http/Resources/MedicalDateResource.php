<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MedicalDateResource extends JsonResource
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
            'date' => $this->date->format('Y-m-d'),
            'order' => $this->order,
            'type' => $this->type,
            'doctor' => [
                'id' => $this->doctor->id,
                'fullname' => $this->doctor->person->fullname,
                'email' => $this->doctor->person->user->email,
            ],
            'patient' => [
                'id' => $this->patient->id,
                'fullname' => $this->patient->person->fullname,
                'email' => $this->patient->person->user->email,
            ],
            'specialty' => $this->specialty ? [
                'id' => $this->specialty->id,
                'name' => $this->specialty->name,
            ] : null,
            'vital_signs' => $this->vital_signs ? [
                'id' => $this->vital_signs->id,
                'height' => $this->vital_signs->height,
                'weight' => $this->vital_signs->weight,
                'blood_pressure_systolic' => $this->vital_signs->blood_pressure_systolic,
                'blood_pressure_diastolic' => $this->vital_signs->blood_pressure_diastolic,
                'temperature' => $this->vital_signs->temperature,
                'oxygen_saturation' => $this->vital_signs->oxygen_saturation,
            ] : null,
            'certificate' => $this->certificates()->first() ? [
                'id' => $this->certificates()->first()->id,
                'url' => route('certificate.show', ['medicalDate' => $this->id]),
            ] : null,
            'created_at' => $this->created_at->setTimezone($this->timezone)->format('Y-m-d H:i:s'),
        ];
    }
}
