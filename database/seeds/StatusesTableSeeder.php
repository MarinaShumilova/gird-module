<?php

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $statusType = [
            'В работе',
            'Завершен',
            'Удален'

        ];

        foreach ($statusType as $s) {
           Status::create(['name' => $s
            ]);
        }

    }
}
