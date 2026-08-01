<?php

namespace App\Livewire\Forms;

use App\Models\LaboratoryOption;
use Livewire\Component;

class FormOrderOptions extends Component
{
    public $order_options = [];

    public function mount()
    {
        foreach (LaboratoryOption::all() as $option) {
            $this->order_options[] = [
                'id' => $option->id,
                'name' => $option->name,
                'price' => $option->price,
            ];
        }
    }

    public function removeOption($index)
    {
        unset($this->order_options[$index]);
        $this->order_options = array_values($this->order_options);
    }

    public function addOption()
    {
        $this->order_options[] = [
            'id' => null,
            'name' => '',
            'price' => 0,
        ];
    }

    public function render()
    {
        return view('livewire.forms.form-order-options');
    }
}
