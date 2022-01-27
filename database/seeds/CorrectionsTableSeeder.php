<?php

use App\Models\Correction;
use Illuminate\Database\Seeder;

class CorrectionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     *
     * Устранение
     */
    public function run()
    {
        $correctionType=[
            'Поставщик',
            'Командировка(Производитель)',
            'Силами заказчика',
            'Сторонняя Организация',
        ];

        foreach ($correctionType as $c){
            Correction::insert(['name'=>$c
            ]);

        }

    }
}
