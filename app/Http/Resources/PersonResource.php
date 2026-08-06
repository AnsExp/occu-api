<?php

namespace App\Http\Resources;

use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PersonResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'fullname' => $this->fullname,
            'phone' => $this->phone,
            'id_card' => $this->id_card,
            'gender' => $this->gender,
            'email' => $this->user?->email,
            'birth_date' => $this->birth_date,
            'nationality' => $this->nationality,
        ];
    }
}
