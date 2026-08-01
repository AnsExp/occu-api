<?php

namespace App\Livewire\Components;

use Livewire\Component;

class ToothCircle extends Component
{
    public $north;
    public $east;
    public $south;
    public $west;
    public $center;

    public function mount($north = null, $east = null, $south = null, $west = null, $center = null)
    {
        $this->north = $north ?? 'normal';
        $this->east = $east ?? 'normal';
        $this->south = $south ?? 'normal';
        $this->west = $west ?? 'normal';
        $this->center = $center ?? 'normal';
    }

    public function change($orientation, $status)
    {
        $this->$orientation = $status;
    }

    public function render()
    {
        return view('livewire.components.tooth-circle');
    }
}
