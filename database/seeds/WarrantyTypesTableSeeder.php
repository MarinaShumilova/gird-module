<?php

use App\Models\WarrantyType;
use Illuminate\Database\Seeder;

class WarrantyTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     *
     * Тип гарантии
     */
    public function run()
    {
        $warrantyType = [
            'Гарантийный',
            'Не гарантийный',

        ];

        foreach ($warrantyType as $w) {
            WarrantyType::create(['name' => $w
            ]);
        }

    }
}
