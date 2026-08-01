<?php

namespace App\Livewire\Forms;

use App\Models\Patient;
use Livewire\Component;

class FormPsychology extends Component
{
    public Patient $patient;
    public $doctors;

    public function render()
    {
        return view('livewire.forms.form-psychology');
    }
}
