<?php

namespace App\Livewire\Forms;

use App\Models\Plan;
use Livewire\Component;

class FormPlan extends Component
{
    public ?Plan $plan = null;
    public array $features = [];

    public function mount(?Plan $plan = null)
    {
        $this->plan = $plan;
        $this->features = $plan?->features ?? [];
    }

    public function addFeature()
    {
        $this->features[] = '';
    }

    public function removeFeature($index)
    {
        unset($this->features[$index]);
        $this->features = array_values($this->features);
    }

    public function render()
    {
        return view('livewire.forms.form-plan');
    }
}
