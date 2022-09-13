<?php

use App\Models\Reason;
use Illuminate\Database\Seeder;

class ReasonsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * Причина гарантии
     */
    public function run()
    {
        $reason=[
            'Фургон',
            'Металлоконструкция',
            'ЛКП',
            'Сборка',
            'Шасси',
            'КМУ',
            'Комплектующие'

        ];

        foreach ($reason as $r){
            Reason::create(['name'=>$r
            ]);

        }

    }
}
