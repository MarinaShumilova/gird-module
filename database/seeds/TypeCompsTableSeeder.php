<?php

use App\Models\TypeComp;
use Illuminate\Database\Seeder;

class TypeCompsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     *
     * Тип рекламации
     *
     */
    public function run()
    {

        $compType = [
            'Отказ',
            'Политика',
            'Платно',
        ];

        foreach ($compType as $c) {
            TypeComp::create(['name' => $c
            ]);
        }


    }
}
