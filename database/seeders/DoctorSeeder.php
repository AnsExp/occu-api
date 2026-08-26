<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\PersonalData;
use App\Models\Specialty;
use App\Models\User;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    private $doctors = [
        [
            'first_name' => 'Carlos Andrés',
            'last_name' => 'Mendoza Torres',
            'id_card' => '0958745601',
            'email' => 'carlos.mendoza@example.com',
        ],
        [
            'first_name' => 'María Fernanda',
            'last_name' => 'Gómez Ramírez',
            'id_card' => '0958745602',
            'email' => 'maria.gomez@example.com',
        ],
        [
            'first_name' => 'Juan Pablo',
            'last_name' => 'Salazar López',
            'id_card' => '0958745603',
            'email' => 'juan.salazar@example.com',
        ],
        [
            'first_name' => 'Ana Sofía',
            'last_name' => 'Martínez Reyes',
            'id_card' => '0958745604',
            'email' => 'ana.martinez@example.com',
        ],
        [
            'first_name' => 'Luis Alberto',
            'last_name' => 'Castillo Vega',
            'id_card' => '0958745605',
            'email' => 'luis.castillo@example.com',
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Specialty::all() as $index => $specialty) {

            if (!isset($this->doctors[$index])) {
                break;
            }

            $doctor = $this->doctors[$index];

            $user = User::updateOrCreate(
                ['email' => $doctor['email']],
                [
                    'name' => $doctor['first_name'] . ' ' . $doctor['last_name'],
                    'email' => $doctor['email'],
                    'password' => bcrypt($doctor['id_card']),
                ]
            );

            $user->assignRole('doctor');

            $person = PersonalData::updateOrCreate(
                ['id_card' => $doctor['id_card']],
                [
                    'first_name' => $doctor['first_name'],
                    'last_name' => $doctor['last_name'],
                    'id_card' => $doctor['id_card'],
                    'email' => $doctor['email'],
                ]
            );

            Doctor::updateOrCreate(
                ['personal_data_id' => $person->id],
                [
                    'specialty_id' => $specialty->id,
                    'user_id' => $user->id,
                ]
            );
        }
    }
}
