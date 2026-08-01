<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Livewire\Component;

class FormResetPassword extends Component
{
    public ?User $user = null;

    public function mount(?User $user = null)
    {
        $this->user = $user ?? auth()->user();
    }

    public function render()
    {
        return view('livewire.forms.form-reset-password');
    }
}
