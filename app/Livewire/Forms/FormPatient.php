<?php

namespace App\Livewire\Forms;

use App\Models\Agreement;
use Livewire\Component;

class FormPatient extends Component
{
    public $patient = null;
    public $agreements = null;

    public function mount($patient = null)
    {
        $this->patient = $patient;
        $this->agreements = Agreement::all();
    }

    public function render()
    {
        return view('livewire.forms.form-patient');
    }
}
