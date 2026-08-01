<?php

namespace App\Livewire\Components;

use App\Models\MedicalDate;
use Livewire\Component;

class MedicalDateFinder extends Component
{
    public $showFinder = true;
    public $medicalDateCode = null;
    public $notFoundMessage = null;

    public function search()
    {
        $medicalDate = MedicalDate::findByCode($this->medicalDateCode);
        if ($medicalDate) {
            $this->showFinder = false;
            $this->dispatch('medicalDateFound', $medicalDate->id);
        } else {
            $this->notFoundMessage = 'No se encontró la cita médica. Si es un error, comunicate con los encargados del sistema.';
        }
    }

    public function render()
    {
        return view('livewire.components.medical-date-finder');
    }
}
