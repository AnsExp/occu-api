<?php

namespace App\Livewire\Forms;

use App\Models\MedicalDate;
use Livewire\Component;

class FormOdontology extends Component
{
    public ?MedicalDate $medicalDate = null;

    public function amount(?MedicalDate $medicalDate = null)
    {
        $this->medicalDate = $medicalDate;
    }

    public function render()
    {
        return view('livewire.forms.form-odontology');
    }
}
