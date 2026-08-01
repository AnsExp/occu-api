<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use App\Models\Specialty;

class FormDoctor extends Component
{
    public $doctor = null;
    public $specialties = [];

    public function mount($doctor = null)
    {
        $this->doctor = $doctor;
        $this->specialties = Specialty::orderBy('name')->get();
    }

    public function render()
    {
        return view('livewire.forms.form-doctor');
    }
}
