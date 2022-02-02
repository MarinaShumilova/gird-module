<?php

use App\Models\TypeComp;
use Illuminate\Database\Seeder;

class TypeCompsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     *
     * Тип рекламации
     *
     */
    public function run()
    {
        Typecomp::create([
            'name' => 'Гарантийный',
        ]);
        Typecomp::create([
            'name' => 'Не гарантийный',
        ]);
    }
}
