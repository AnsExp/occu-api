<?php

namespace App\Livewire\Components;

use App\Models\Person;
use Livewire\Component;

class PersonFinder extends Component
{
    public $id_card = null;
    public $patientExists = false;

    public function searchPatient()
    {
        $patient = Person::findByIdCard($this->id_card);
        $this->patientExists = $patient ? true : false;
        $this->dispatch('personSelected', $patient ? $patient->id : null);
    }

    public function render()
    {
        return view('livewire.components.person-finder');
    }
}
