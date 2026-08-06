<?php

namespace App\Livewire\Forms;

use App\Models\MedicalDate;
use App\Models\Specialty;
use App\Models\VitalSign;
use Livewire\Component;

class FormVitalSigns extends Component
{
    public Specialty $specialty;
    public MedicalDate $medicalDate;
    public array $data = [];

    public function mount(Specialty $specialty, MedicalDate $medicalDate)
    {
        if ($medicalDate->patient_id) {
            $last = VitalSign::where('patient_id', $medicalDate->patient_id)->latest()->first();
            $this->data = $last?->toArray() ?? [];
        }
    }

    public function render()
    {
        return view('livewire.forms.form-vital-signs');
    }
}
