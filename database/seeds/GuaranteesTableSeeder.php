<?php

use App\Models\Guarantee;
use Illuminate\Database\Seeder;

class GuaranteesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     *
     *
     * Гарантии
     */
    public function run()
    {
        Guarantee::create([
            'name' => 'Политика',
        ]);

        Guarantee::create([
            'name' => 'Производство'
        ]);
    }
}
