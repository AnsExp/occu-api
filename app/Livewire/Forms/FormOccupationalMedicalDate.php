<?php

namespace App\Livewire\Forms;

use App\Models\Agreement;
use App\Models\Doctor;
use App\Models\Person;
use App\Models\Specialty;
use Livewire\Attributes\Computed;
use Livewire\Component;

class FormOccupationalMedicalDate extends Component
{
    public ?Person $person = null;
    public ?Agreement $agreement = null;
    public bool $isCustomizingAgreement = false;
    public array $medicalDates = [];
    public ?int $occupationalDoctorSelected = null;

    protected $listeners = [
        'personSelected' => 'setPerson',
    ];

    #[Computed]
    public function specialties()
    {
        return Specialty::with(['doctors.person'])->orderBy('name')->get();
    }

    #[Computed]
    public function occupationalDoctors()
    {
        return Doctor::with('person')->where('is_occupational_doctor', true)->get();
    }

    public function setPerson(?int $personId): void
    {
        $this->person = $personId ? Person::find($personId) : null;
        $this->agreement = $this->person?->patient?->agreement;
        $this->medicalDates = [];

        if ($this->agreement) {
            foreach ($this->agreement->requirements as $requirement) {
                $this->addMedicalDate($requirement->specialty);
            }
            $this->isCustomizingAgreement = false;
        }
    }

    public function addMedicalDate(?Specialty $specialty = null): void
    {
        $specialty ??= $this->specialties->first();

        if (!$specialty) {
            return;
        }

        $this->medicalDates[] = [
            'date' => date('Y-m-d'),
            'doctor_id' => $specialty->doctors->first()?->id,
            'specialty_id' => $specialty->id,
            'price' => (float) $specialty->price_base,
        ];
    }

    public function syncMedicalDateSpecialty(int $index, mixed $specialtyId): void
    {
        if (!isset($this->medicalDates[$index])) {
            return;
        }

        $specialtyId = (int) $specialtyId;
        $this->medicalDates[$index]['specialty_id'] = $specialtyId;

        $specialty = $this->specialties->firstWhere('id', $specialtyId);

        if (!$specialty) {
            $this->medicalDates[$index]['price'] = 0;
            $this->medicalDates[$index]['doctor_id'] = null;
            return;
        }

        $this->medicalDates[$index]['price'] = (float) $specialty->price_base;
        $this->medicalDates[$index]['doctor_id'] = $specialty->doctors->first()?->id;
    }

    public function toggleAgreementCustomization(): void
    {
        $this->isCustomizingAgreement = !$this->isCustomizingAgreement;
    }

    public function removeMedicalDate(int $index): void
    {
        unset($this->medicalDates[$index]);
        $this->medicalDates = array_values($this->medicalDates);
    }

    #[Computed]
    public function subtotal(): float
    {
        return collect($this->medicalDates)->sum(fn($d) => (float) ($d['price'] ?? 0));
    }

    #[Computed]
    public function taxAmount(): float
    {
        return round($this->subtotal() * ((float) config('app.tax_rate', 0)), 2);
    }

    #[Computed]
    public function total(): float
    {
        return round($this->subtotal() + $this->taxAmount(), 2);
    }

    public function render()
    {
        return view('livewire.forms.form-occupational-medical-date');
    }
}
