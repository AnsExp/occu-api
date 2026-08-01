<?php

namespace App\Livewire\Forms;

use App\Models\Agreement;
use App\Models\Specialty;
use Livewire\Component;

class FormAgreement extends Component
{
    public ?Agreement $agreement = null;
    public $discountType = '';
    public $specialties = [];
    public $specialtySelected = '';
    public $specialtiesSelected = [];

    public function mount(?Agreement $agreement = null)
    {
        $this->agreement = $agreement;
        if ($this->agreement) {
            $this->discountType = $this->agreement->discount_type;
        }
        $this->specialties = Specialty::all();
    }

    public function updatedSpecialtySelected($value)
    {
        if (!in_array($value, $this->specialtiesSelected)) {
            $this->specialtiesSelected[] = $value;
        }
        $this->specialtySelected = '';
    }

    public function removeSpecialty($value)
    {
        $this->specialtiesSelected = array_filter($this->specialtiesSelected, function ($item) use ($value) {
            return $item != $value;
        });
    }

    public function render()
    {
        return view('livewire.forms.form-agreement');
    }
}
