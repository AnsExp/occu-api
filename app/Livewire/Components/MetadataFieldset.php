<?php

namespace App\Livewire\Components;

use Livewire\Component;

class MetadataFieldset extends Component
{
    public $metadata = [];

    public function mount($metadata = [])
    {
        $this->metadata = $metadata;
    }

    public function addMetadata()
    {
        $this->metadata[] = ['key' => '', 'value' => ''];
    }

    public function removeMetadata($index)
    {
        unset($this->metadata[$index]);
        // $this->metadata = array_values($this->metadata);
    }

    public function render()
    {
        return view('livewire.components.metadata-fieldset');
    }
}
