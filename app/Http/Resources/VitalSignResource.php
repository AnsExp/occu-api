<?php

namespace App\Http\Resources;

use App\Models\VitalSign;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VitalSignResource extends JsonResource
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
            'height' => $this->height,
            'weight' => $this->weight,
            'blood_pressure_systolic' => $this->blood_pressure_systolic,
            'blood_pressure_diastolic' => $this->blood_pressure_diastolic,
            'temperature' => $this->temperature,
            'oxygen_saturation' => $this->oxygen_saturation,
        ];
    }
}
