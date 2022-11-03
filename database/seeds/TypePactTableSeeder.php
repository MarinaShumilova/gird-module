<?php

use App\Models\TypePact;
use Illuminate\Database\Seeder;

class TypePactTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pact = [
            'Входящие',
            'Исходящие',
        ];

        foreach ($pact as $p){
            TypePact::create(['name'=>$p]);
        }
    }
}
