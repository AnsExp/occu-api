<?php

namespace App\Livewire\Forms;

use App\Models\Doctor;
use App\Models\Specialty;
use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;
// use Livewire\Form;

class FormUser extends Component
{
    public ?User $user = null;
    // public ?Doctor $doctor = null;
    public ?string $role_selected = null;
    public ?string $specialty_selected = null;
    public $roles;
    public $specialties;

    public function mount(?User $user = null)
    {
        $this->user = $user;

        $this->roles = Role::all();
        $this->specialties = Specialty::all();

        if ($user) {
            $this->role_selected = $user->roles()->first()->id;
            $this->specialty_selected = $user->person?->doctor?->specialty->id;
        }
    }

    public function render()
    {
        return view('livewire.forms.form-user');
    }
}
