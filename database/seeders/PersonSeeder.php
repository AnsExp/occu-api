<?php

namespace Database\Seeders;

use App\Models\PersonalData;
use Illuminate\Database\Seeder;

class PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PersonalData::updateOrCreate(
            ['id_card' => '0751057027'],
            [
                'first_name' => 'Roosevelt Stalin',
                'last_name' => 'Remache Abrigo',
                'id_card' => '0751057027',
                'email' => 'rooseveltabrigo@gmail.com',
            ]
        );
    }
}
