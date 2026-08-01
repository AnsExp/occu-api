<?php

namespace App\Livewire\Forms;

use App\Models\MedicalDate;
use App\Models\Person;
use App\Models\Specialty;
use Livewire\Component;

class FormMedicalDate extends Component
{
    public ?Person $person = null;
    public ?MedicalDate $medicalDate = null;
    public ?Specialty $specialty = null;
    public $specialties = [];

    public $specialtySelected;

    protected $listeners = [
        'personSelected' => 'setPerson',
    ];

    public function setPerson($personId)
    {
        $this->person = $personId ? Person::find($personId) : null;
    }

    public function updatedSpecialtySelected($specialtyId)
    {
        $this->specialty = Specialty::find($specialtyId);
    }

    public function mount(?MedicalDate $medicalDate = null)
    {
        $this->specialties = Specialty::orderBy('name')->get();
        $this->medicalDate = $medicalDate;
        if ($medicalDate) {
            $this->specialty = $medicalDate->specialty;
            $this->person = $medicalDate->patient->person;
        } else {
            $this->specialty = $this->specialties->first();
        }
    }

    public function render()
    {
        return view('livewire.forms.form-medical-date');
    }
}
