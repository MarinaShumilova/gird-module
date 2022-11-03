<?php

use App\Models\Culprit;
use Illuminate\Database\Seeder;

class CulpritsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * Виновная сторона
     */
    public function run()
    {
        $culpritType=[
            'Поставщик',
            'Потребитель',
            'Производство ГИРД',

        ];

        foreach ($culpritType as $с){
            Culprit::create(['name'=>$с
            ]);

        }
    }
}
