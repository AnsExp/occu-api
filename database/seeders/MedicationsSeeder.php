<?php

namespace Database\Seeders;

use App\Models\Medication;
use Illuminate\Database\Seeder;

class MedicationsSeeder extends Seeder
{
    private array $medications = [
        ["name" => "Paracetamol", "price" => 2.50],
        ["name" => "Ibuprofeno", "price" => 3.75],
        ["name" => "Amoxicilina", "price" => 12.00],
        ["name" => "Omeprazol", "price" => 8.40],
        ["name" => "Loratadina", "price" => 5.20],
        ["name" => "Diclofenaco", "price" => 4.10],
        ["name" => "Metformina", "price" => 6.80],
        ["name" => "Atorvastatina", "price" => 15.00],
        ["name" => "Losartán", "price" => 9.50],
        ["name" => "Salbutamol", "price" => 7.25],
        ["name" => "Claritromicina", "price" => 18.00],
        ["name" => "Prednisona", "price" => 3.90],
        ["name" => "Ranitidina", "price" => 6.00],
        ["name" => "Cetirizina", "price" => 4.75],
        ["name" => "Azitromicina", "price" => 14.50],
        ["name" => "Tramadol", "price" => 11.20],
        ["name" => "Furosemida", "price" => 5.60],
        ["name" => "Enalapril", "price" => 7.80],
        ["name" => "Insulina", "price" => 25.00],
        ["name" => "Vitamina C", "price" => 3.30],
        ["name" => "Aspirina", "price" => 2.90],
        ["name" => "Clonazepam", "price" => 13.40],
        ["name" => "Levotiroxina", "price" => 10.50],
        ["name" => "Warfarina", "price" => 16.20],
        ["name" => "Alprazolam", "price" => 12.75],
        ["name" => "Naproxeno", "price" => 5.60],
        ["name" => "Hidroxicloroquina", "price" => 19.00],
        ["name" => "Dexametasona", "price" => 8.90],
        ["name" => "Ciprofloxacino", "price" => 17.50],
        ["name" => "Gabapentina", "price" => 14.20],
        ["name" => "Metronidazol", "price" => 6.80],
        ["name" => "Clindamicina", "price" => 15.30],
        ["name" => "Amlodipino", "price" => 9.10],
        ["name" => "Simvastatina", "price" => 11.50],
        ["name" => "Risperidona", "price" => 13.90],
        ["name" => "Tamsulosina", "price" => 7.40],
        ["name" => "Levomepromazina", "price" => 18.60],
        ["name" => "Citalopram", "price" => 12.80],
        ["name" => "Duloxetina", "price" => 14.90],
        ["name" => "Sertralina", "price" => 13.20],
        ["name" => "Escitalopram", "price" => 15.70],
        ["name" => "Fluoxetina", "price" => 11.30],
        ["name" => "Bupropiona", "price" => 16.80],
        ["name" => "Mirtazapina", "price" => 14.50],
        ["name" => "Venlafaxina", "price" => 13.60],
        ["name" => "Clonidina", "price" => 9.90],
        ["name" => "Metoclopramida", "price" => 7.20],
        ["name" => "Ondansetrón", "price" => 10.40],
        ["name" => "Ranitidina", "price" => 6.00],
        ["name" => "Loperamida", "price" => 5.50],
        ["name" => "Difenidramina", "price" => 4.80],
        ["name" => "Clorfenamina", "price" => 3.70],
        ["name" => "Cetirizina", "price" => 4.75],
        ["name" => "Loratadina", "price" => 5.20],
        ["name" => "Fexofenadina", "price" => 6.10],
        ["name" => "Desloratadina", "price" => 7.30],
        ["name" => "Levocetirizina", "price" => 8.40],
        ["name" => "Montelukast", "price" => 9.50],
        ["name" => "Budesonida", "price" => 10.60],
        ["name" => "Fluticasona", "price" => 11.70],
        ["name" => "Beclometasona", "price" => 12.80],
        ["name" => "Mometasona", "price" => 13.90],
        ["name" => "Triamcinolona", "price" => 14.00],
        ["name" => "Prednisolona", "price" => 15.10],
        ["name" => "Dexametasona", "price" => 16.20],
        ["name" => "Hidrocortisona", "price" => 17.30],
        ["name" => "Metilprednisolona", "price" => 18.40],
        ["name" => "Betametasona", "price" => 19.50],
        ["name" => "Fluocinolona", "price" => 20.60],
        ["name" => "Clobetasol", "price" => 21.70],
        ["name" => "Diflucortolona", "price" => 22.80],
        ["name" => "Halometasona", "price" => 23.90],
        ["name" => "Mometasona furoato", "price" => 24.00],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->medications as $item) {
            Medication::updateOrCreate(
                ['name' => $item['name']],
                ['price' => $item['price']]
            );
        }
    }
}
