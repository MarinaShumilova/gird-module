<?php

use Illuminate\Database\Seeder;

class WarrantyDecreesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     *
     * № гарантийного приказа
     */
    public function run()
    {
        $warrantysType = [
            '5648',
            '6545'
        ];

        foreach ($warrantysType as $w) {
            \App\Models\WarrantyDecree::create(['number' => $w
            ]);
        }
    }
}
