<?php

namespace App\Http\Resources;

use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuditLogResource extends JsonResource
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
            'table' => $this->table,
            'record_id' => $this->record_id,
            'action' => $this->action,
            'changes' => $this->changes,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email,
            ],
            'ip_address' => $this->ip_address,
            'user_agent' => $this->user_agent,
            'created' => $this->created_at->diffForHumans(),
        ];
    }
}
