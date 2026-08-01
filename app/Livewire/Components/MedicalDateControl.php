<?php

namespace App\Livewire\Components;

use App\Models\MedicalDate;
use Livewire\Component;

class MedicalDateControl extends Component
{
    public string $name;
    public bool $locked = false;
    public $specialties;
    public $specialtySelected;

    protected $listeners = [
    ];

    public function setLocked(string $name, bool $locked)
    {
        if ($this->name === $name) {
            $this->locked = $locked;
        }
    }

    public function mount(string $name, ?int $specialtyId = null)
    {
    }

    public function render()
    {
        return view('livewire.components.medical-date-control');
    }
}
