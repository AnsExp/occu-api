<?php

namespace App\Livewire\Forms;

use App\Models\LaboratoryOption;
use App\Models\Person;
use Livewire\Component;

class FormLaboratoryOrder extends Component
{
    public $patient = null;
    public $order_options = [];

    protected $listeners = [
        'personSelected' => 'setPerson',
    ];

    public function setPerson($personId)
    {
        $this->patient = $personId ? Person::find($personId) : null;
    }

    public function mount()
    {
        $this->order_options = LaboratoryOption::orderBy('name')->get()->map(fn($option) => [
            'id' => $option->id,
            'name' => $option->name,
            'price' => $option->price,
            'selected' => true,
            'quantity' => 1,
        ]);
    }

    public function render()
    {
        return view('livewire.forms.form-laboratory-order');
    }
}
