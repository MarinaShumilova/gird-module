<?php

use App\Models\CauseWarranty;
use Illuminate\Database\Seeder;

class CauseWarrantyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     *
     * Причина гарантии
     */
    public function run()
    {
        $warrantyCause=[
            'Поставщик',
            'Фургон',
            'Металлоконструкция',
            'ЛКП',
            'Сборка',
            'Шасси',
            'КМУ',
            'Комплектующие'

        ];

        foreach ($warrantyCause as $w){
            CauseWarranty::insert(['name'=>$w
            ]);

        }

    }
}
