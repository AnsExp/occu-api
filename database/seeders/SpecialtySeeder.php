<?php

namespace Database\Seeders;

use App\Models\Specialty;
use Illuminate\Database\Seeder;

class SpecialtySeeder extends Seeder
{
    private array $items = [
        ['name' => 'Audiología', 'price_base' => 25, 'form' => 'forms.form-audiology',],
        ['name' => 'Odontología', 'price_base' => 50, 'form' => 'forms.form-odontology',],
        ['name' => 'Oftalmología', 'price_base' => 75, 'form' => 'forms.form-ophthalmology',],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->items as $item) {
            Specialty::updateOrCreate(
                ['slug' => occu_slug($item['name'])],
                [
                    'name' => $item['name'],
                    'price_base' => $item['price_base'],
                    'form' => $item['form']
                ]
            );
        }
    }
}
