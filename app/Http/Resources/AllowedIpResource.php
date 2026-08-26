<?php

namespace App\Http\Resources;

use App\Models\AllowedIp;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AllowedIpResource extends JsonResource
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
            'ip_address' => $this->ip_address,
            'notes' => $this->notes,
            'expires_at' => $this->expires_at,
        ];
    }
}
