<?php

namespace App\Livewire\Forms;

use App\Models\Medication;
use App\Models\Person;
use Livewire\Component;

class FormPrescription extends Component
{
    public $person = null;
    public $medications = [];
    public $medicationsSelected = [];
    public $currentOption = '';

    protected $listeners = [
        'personSelected' => 'setPersonId',
    ];

    public function setPersonId($personId)
    {
        if ($personId) {
            $this->person = Person::find($personId);
        }
    }

    public function updatedCurrentOption($value)
    {
        $medication = Medication::find($value);
        if ($medication && !in_array($medication->id, $this->medicationsSelected)) {
            $this->medicationsSelected[] = $medication->id;
        }
        $this->currentOption = '';
    }

    public function removeMedication($medicationId)
    {
        $this->medicationsSelected = array_filter($this->medicationsSelected, function ($id) use ($medicationId) {
            return $id != $medicationId;
        });
    }

    public function mount()
    {
        $this->medications = Medication::orderBy('name')->get();
    }

    public function render()
    {
        return view('livewire.forms.form-prescription');
    }
}
