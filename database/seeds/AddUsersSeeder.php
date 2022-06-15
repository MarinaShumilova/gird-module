<?php

use Illuminate\Database\Seeder;
use GirdBase\Models\Module;
use App\Models\Profile;
use GirdBase\Models\User;




class AddUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 = User::create([
            'name' => 'Galina',
            'email' => 'galina@em',
            'password' => Hash::make('123')
        ]);

        // обязательное условие для пользования модулем
        $user1->modules()->attach(Module::where('name', config('app.name'))->first());
        $profile1 = $user1->profile()->save(new Profile());
        //
        $profile1->attachRole('1');


        $user2 = User::create([
            'name' => 'Anonim',
            'email' => 'anonim@em',
            'password' => Hash::make('123')
        ]);

        // обязательное условие для пользования модулем
        $user2->modules()->attach(Module::where('name', config('app.name'))->first());
        $profile2 = $user2->profile()->save(new Profile());

        $profile2->attachRole('2');


        $user3 = User::create([
            'name' => 'Marina',
            'email' => 'marina@em',
            'password' => Hash::make('123')
        ]);

        // обязательное условие для пользования модулем
        $user3->modules()->attach(Module::where('name', config('app.name'))->first());
        $profile3 = $user3->profile()->save(new Profile());

        $profile3->attachRole('1');



    }
}
