<?php

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
        \App\Models\Status::create([
            'name' => 'В работе',
        ]);
        \App\Models\Status::create([
            'name' => 'Завершен',
        ]);
        \App\Models\Status::create([
            'name' => 'Удален',
        ]);
    }
}
