<?php

namespace App\Livewire\Forms;

use App\Models\AllowedIp;
use Illuminate\Http\Request;
use Livewire\Component;

class FormAllowedIps extends Component
{
    public $ips = [];

    public function mount()
    {
        foreach (AllowedIp::all() as $allowedIp) {
            $this->ips[] = [
                'ip' => $allowedIp->ip,
                'notes' => $allowedIp->notes,
                'expires_at' => $allowedIp->expires_at?->format('Y-m-d') ?? null,
            ];
        }
    }

    public function addIp()
    {
        $this->ips[] = [
            'ip' => '',
            'notes' => '',
            'expires_at' => null,
        ];
    }

    public function removeIp(int $index)
    {
        unset($this->ips[$index]);
    }

    public function render()
    {
        return view('livewire.forms.form-allowed-ips');
    }
}
