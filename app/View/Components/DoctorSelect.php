<?php

namespace App\View\Components;

use App\Enums\SpecialtyEnum;
use App\Models\Doctor;
use App\Models\Specialty;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DoctorSelect extends Component
{
    private $doctors;

    /**
     * Create a new component instance.
     */
    public function __construct(?string $specialty = null)
    {
        if ($specialty) {
            $specialty = Specialty::where('name', $specialty)->first();
            $this->doctors = Doctor::where('specialty_id', $specialty->id)
                ->with('user')
                ->get();
        } else {
            $this->doctors = Doctor::all();
        }
        $this->doctors = $this->doctors->map(function (Doctor $doctor) {
            $specialty = '';
            if ($doctor->specialty()) {
                set_setting('sample', $doctor->specialty());
                $specialty = '(' . SpecialtyEnum::fromCode($doctor->specialty()->name) . ')';
            }
            return [
                'id' => $doctor->id,
                'name' => $doctor->first_name . ' ' . $doctor->last_name,
                'specialty' => $specialty,
            ];
        });
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.doctor-select', ['doctors' => $this->doctors]);
    }
}
