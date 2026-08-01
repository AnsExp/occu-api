<?php

namespace Tests\Feature;

use App\Models\Doctor;
use App\Models\MedicalDate;
use App\Models\Patient;
use App\Models\Person;
use App\Models\Specialty;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VitalSignRouteTest extends TestCase
{
    use RefreshDatabase;

    public function test_vital_sign_route_resolves_medical_date_by_code(): void
    {
        $user = User::factory()->create();

        $specialty = Specialty::create([
            'slug' => 'audiologia',
            'name' => 'Audiología',
            'description' => 'Test',
            'price_base' => 10.00,
        ]);

        $person = Person::create([
            'first_name' => 'Ana',
            'last_name' => 'Pérez',
            'phone' => '0999999999',
            'id_card' => '1712345678',
            'id_card_hash' => 'hash-test',
            'user_id' => $user->id,
        ]);

        $patient = Patient::create([
            'person_id' => $person->id,
        ]);

        $doctor = Doctor::create([
            'person_id' => $person->id,
            'specialty_id' => $specialty->id,
            'is_occupational_doctor' => false,
        ]);

        $medicalDate = MedicalDate::create([
            'code' => 'CIT-20260728-3',
            'doctor_id' => $doctor->id,
            'patient_id' => $patient->id,
            'specialty_id' => $specialty->id,
            'date' => now(),
            'price' => 10.00,
            'timezone' => 'America/Guayaquil',
            'order' => 1,
        ]);

        $this->actingAs($user);

        $response = $this->get("/dashboard/{$specialty->slug}/{$medicalDate->code}/vital_signs");

        $response->assertOk();
    }
}
