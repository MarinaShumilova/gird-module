<?php

use App\Models\Firms;
use Illuminate\Database\Seeder;

class FirmsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $firm = [
            'Мизатеф',
            'ГАФ',
        ];

        foreach ($firm as $f){
           Firms::create(['name'=>$f]);
        }
    }
}
