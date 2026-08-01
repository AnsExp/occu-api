<?php

namespace App\Livewire\Forms;

use App\Models\MedicalDate;
use Livewire\Component;

class FormOphthalmology extends Component
{
    public MedicalDate $medicalDate;
    public $doctors;
    public ?string $correctiveLenses = null;
    public array $snapshot = [];

    public function mount(MedicalDate $medicalDate)
    {
        $this->medicalDate = $medicalDate;
        $this->doctors = $medicalDate->specialty->doctors()->get();
        if ($medicalDate->certificate_id) {
            $this->snapshot = $medicalDate->certificate->snapshot ?? [];
        }
    }

    public function render()
    {
        return view('livewire.forms.form-ophthalmology');
    }
}
