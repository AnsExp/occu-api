<?php

namespace App\Livewire\Forms;

use App\Models\Certificate;
use App\Models\CertificateKey;
use App\Models\MedicalDate;
use Livewire\Component;

class FormAudiology extends Component
{
    public MedicalDate $medicalDate;
    public array $snapshot = [];

    public ?Certificate $certificate = null;
    public ?CertificateKey $certificateKey = null;

    public function mount(MedicalDate $medicalDate)
    {
        $this->medicalDate = $medicalDate;
        $this->snapshot = $medicalDate->certificate?->snapshot ?? [];
    }

    public function render()
    {
        return view('livewire.forms.form-audiology');
    }
}
