<?php

namespace App\View\Components;

use App\Models\Specialty;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Navbar extends Component
{
    public array $links = [];

    /**
     * Create a new component instance.
     */
    public function __construct()
    {

        $this->links[] = ['name' => __('auth.home'), 'route' => route('home')];

        if (auth()->check()) {

            $user = auth()->user();

            if ($user->can('read.plans'))
                $this->links[] = ['name' => 'Planes', 'route' => route('plans.index')];

            if ($user->can('read.agreements'))
                $this->links[] = ['name' => 'Convenios', 'route' => route('agreements.index')];

            if ($user->can('read.prescriptions'))
                $this->links[] = ['name' => 'Farmacia', 'route' => route('prescriptions.index')];

            if ($user->can('read.medical_dates'))
                $this->links[] = ['name' => 'Citas Médicas', 'route' => route('medical_dates.index')];

            if ($user->can('read.laboratory_orders'))
                $this->links[] = ['name' => 'Ordenes de Laboratorio', 'route' => route('laboratory_orders.index')];

            if ($user->can('read.patients'))
                $this->links[] = ['name' => 'Pacientes', 'route' => route('patients.index')];

            if ($user->can('read.doctors'))
                $this->links[] = ['name' => 'Doctores', 'route' => route('doctors.index')];

            if ($user->can('read.medical_dates')) {
                $this->links[] = ['name' => 'Especialidades', 'route' => route('specialties.index')];
                foreach (Specialty::all() as $specialty) {
                    $this->links[] = ['name' => $specialty->name, 'route' => route('dashboard.index', $specialty->slug)];
                }
            }

            if ($user->can('read.occupational_medical_dates'))
                $this->links[] = ['name' => 'Medicina Ocupacional', 'route' => route('occupational_medical_dates.index')];

            if ($user->can('read.users'))
                $this->links[] = ['name' => 'Usuarios', 'route' => route('users.index')];

            if ($user->hasRole('administrator'))
                $this->links[] = ['name' => 'Sistema', 'route' => route('dashboard.system')];

            $this->links[] = ['name' => __('auth.logout'), 'route' => route('auth.logout')];

        } else {

            $this->links[] = ['name' => __('auth.login'), 'route' => route('login')];

        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.navbar');
    }
}
