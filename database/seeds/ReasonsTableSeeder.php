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
            'Нет информации',
            'Опытное производство',
            'Отдел главного конструктора',
            'Отдел НИОКР',
            'Проживание водителей',
            'Участок доработки шасси',
            'Участок заготовки и сборки фургонов',
            'Участок металлоконструкций',
            'Участок сборки Спецтехники'

        ];

        foreach ($reason as $r){
            Reason::create(['name'=>$r
            ]);

        }

    }
}
