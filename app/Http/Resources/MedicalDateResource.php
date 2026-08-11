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
            'timezone' => $this->timezone,
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
                'slug' => $this->specialty->slug,
            ] : null,
            'vital_signs' => $this->vitalSigns ? [
                'id' => $this->vitalSigns->id,
                'height' => (float) $this->vitalSigns->height,
                'weight' => (float) $this->vitalSigns->weight,
                'blood_pressure_systolic' => (int) $this->vitalSigns->blood_pressure_systolic,
                'blood_pressure_diastolic' => (int) $this->vitalSigns->blood_pressure_diastolic,
                'temperature' => (float) $this->vitalSigns->temperature,
                'oxygen_saturation' => (float) $this->vitalSigns->oxygen_saturation,
            ] : null,
            'certificate' => $this->certificates()->first() ? [
                'id' => $this->certificates()->first()->id,
                'url' => route('certificate.show', ['certificate' => $this->certificates()->first()]),
            ] : null,
            'created_at' => $this->created_at->setTimezone($this->timezone)->format('Y-m-d H:i:s'),
        ];
    }
}
