<?php

namespace Database\Seeders;

use App\Models\Agreement;
use App\Models\AgreementRequirement;
use App\Models\Specialty;
use Illuminate\Database\Seeder;

class AgreementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $agreement = Agreement::updateOrCreate(
            ['institution' => 'Universidad de San Martín de Porres'],
            [
                'description' => 'Convenio con la Universidad de San Martín de Porres para brindar servicios médicos a sus estudiantes y personal académico.',
                'discount_type' => 'percentage',
                'discount_amount' => 20,
            ]
        );

        foreach (Specialty::all() as $specialty) {
            AgreementRequirement::updateOrCreate(
                ['agreement_id' => $agreement->id, 'specialty_id' => $specialty->id],
                ['agreement_id' => $agreement->id, 'specialty_id' => $specialty->id]
            );
        }
    }
}
