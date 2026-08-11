<?php

namespace App\Http\Resources;

use App\Models\Agreement;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AgreementResource extends JsonResource
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
            'institution' => $this->institution,
            'description' => $this->description,
            'discount_type' => $this->discount_type,
            'discount_amount' => (float) $this->discount_amount,
            'requirements' => array_map(fn($requirement) => [
                'id' => $requirement->specialty->id,
                'name' => $requirement->specialty->name,
            ], $this->requirements->all()),
        ];
    }
}
