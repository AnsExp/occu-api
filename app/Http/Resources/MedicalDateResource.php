<?php

namespace App\Http\Resources;

use App\Models\MedicalDate;
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
            'shift' => $this->shift,
            'type' => $this->type,
            'doctor' => DoctorResource::make($this->doctor),
            'patient' => PatientResource::make($this->patient),
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
            'relationship' => array_map(fn($relationship) => self::make($relationship->related), $this->relationship->all()),
            'documents' => array_map(fn($document) => DocumentResource::make($document), $this->documents->all()),
            'document' => $this->latestDocument ? DocumentResource::make($this->latestDocument) : null,
            'created_at' => $this->created_at->setTimezone($this->timezone)->format('Y-m-d H:i:s'),
        ];
    }
}
