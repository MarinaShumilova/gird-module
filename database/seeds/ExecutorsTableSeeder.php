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
            'Поставщик',
            'Командировка(Производитель)',
            'Силами заказчика',
            'Сторонняя Организация',
        ];

        foreach ($executorsType as $ex) {
            Executor::insert(['name' => $ex
            ]);

        }
    }
}
