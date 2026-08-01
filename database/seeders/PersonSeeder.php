<?php

namespace Database\Seeders;

use App\Models\Person;
use App\Models\User;
use Illuminate\Database\Seeder;

class PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::updateOrCreate(
            ['email_hash' => occu_hash('rooseveltabrigo@gmail.com')],
            [
                'name' => 'Roosevelt Stalin Remache Abrigo',
                'email' => 'rooseveltabrigo@gmail.com',
                'password' => bcrypt('0751057027'),
            ]
        );
        Person::updateOrCreate(
            ['id_card_hash' => occu_hash('0751057027')],
            [
                'first_name' => 'Roosevelt Stalin',
                'last_name' => 'Remache Abrigo',
                'id_card' => '0751057027',
                'user_id' => $user->id,
            ]
        );
    }
}
