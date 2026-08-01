<?php

namespace App\Livewire\Forms;

use App\Models\Specialty;
use Livewire\Component;

class FormSpecialty extends Component
{
    public ?Specialty $specialty = null;

    public function mount(?Specialty $specialty = null)
    {
        $this->specialty = $specialty;
    }

    public function render()
    {
        return view('livewire.forms.form-specialty');
    }
}
