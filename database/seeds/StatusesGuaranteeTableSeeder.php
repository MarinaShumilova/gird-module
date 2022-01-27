<?php

use App\Models\StatusGuarantee;
use Illuminate\Database\Seeder;

class StatusesGuaranteeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * Статус гарантии
     */
    public function run()
    {
        StatusGuarantee::create([
            'name' => 'Гарантийный',
        ]);
        StatusGuarantee::create([
            'name' => 'Не гарантийный',
        ]);

    }

}
