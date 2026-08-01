<?php

namespace Database\Seeders;

use App\Models\LaboratoryOption;
use Illuminate\Database\Seeder;

class OrderOptionSeeder extends Seeder
{
    private array $items = [
        ['name' => 'ELECTROCARDIOGRAMA', 'price' => 25,],
        ['name' => 'BIOMETRIA COSTA', 'price' => 7,],
        ['name' => 'RX TORAX STANDAR AP', 'price' => 30,],
        ['name' => 'TRIGLICERIDOS', 'price' => 2.9,],
        ['name' => 'INSUMOS CARNET DE TIPIFICACION', 'price' => 1.71,],
        ['name' => 'CONSULTA PSICOLOGÍA', 'price' => 20,],
        ['name' => 'CONSULTA MEDICINA GENERAL', 'price' => 15,],
        ['name' => 'CONSULTA OPTOMETRICA', 'price' => 15,],
        ['name' => 'DIAGNOSTICO ODONTOLOGICO', 'price' => 20,],
        ['name' => 'COLESTEROL', 'price' => 3.5,],
        ['name' => 'AUDIOMETRIA', 'price' => 20,],
        ['name' => 'EMO', 'price' => 4,],
        ['name' => 'TIPIFICACION SANGUINEA', 'price' => 5.03,],
        ['name' => 'TGO/ASAT', 'price' => 3.9,],
        ['name' => 'UREA / BUN', 'price' => 2.8,],
        ['name' => 'TGP/ALAT', 'price' => 3.9,],
        ['name' => 'COPROPARASITARIO', 'price' => 3.5,],
        ['name' => 'CREATININA', 'price' => 3.6,],
        ['name' => 'HIV 1 2', 'price' => 11,],
        ['name' => 'ACIDO URICO', 'price' => 3,],
        ['name' => 'GLUCOSA BASAL', 'price' => 2.9,],
        ['name' => 'VDRL', 'price' => 6,],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->items as $item) {
            LaboratoryOption::updateOrCreate(
                ['name' => $item['name']],
                ['price' => $item['price']]
            );
        }
    }
}
