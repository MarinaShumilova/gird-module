<?php

use App\Models\Executor;
use Illuminate\Database\Seeder;

class ExecutorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $executorsType = [
            'Отправить ТМЦ',
            'Командировка',
            'Силами заказчика',
            'Сторонняя организация',
            'На территории ГИРД',
            'Поставщик'

        ];

        foreach ($executorsType as $ex) {
            Executor::create(['name' => $ex
            ]);

        }
    }
}
