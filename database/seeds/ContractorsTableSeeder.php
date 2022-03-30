<?php

use App\Models\Contractor;
use Illuminate\Database\Seeder;

class ContractorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     *
     * Контрагент
     */
    public function run()
    {
        //
        $contractors = [
            [
                'inn' => '8787987',
                'name' => 'Kamaz'
            ],
            [
                'inn' => '8787988887',
                'name' => 'Yral'
            ],

        ];



        foreach ($contractors as $contractor) {
            Contractor::create($contractor);
        }


    }
}
