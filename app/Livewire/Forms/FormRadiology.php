<?php

namespace App\Livewire\Forms;

use App\Models\Doctor;
use App\Models\Specialty;
use Livewire\Component;

class FormRadiology extends Component
{
    public $order;
    public $doctors;

    public function mount($order)
    {
        $this->order = $order;
        $this->doctors = Doctor::where('specialty_id', Specialty::where('name', 'radiology')->first()?->id ?? null)->get();
    }

    public function render()
    {
        return view('livewire.forms.form-radiology');
    }
}
