<?php

use GirdBase\Models\Module;
use App\Models\Profile;
use GirdBase\Models\User;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userIds = [2, 30];

        foreach ($userIds as $id)
        {
            $user = User::find($id);
            $user->profile()->save(new Profile());
            $user->profile->attachRole('admin');
        }

        // обязательное условие для пользования модулем
//        $user->modules()->attach(Module::where('name', config('app.name'))->first());
//        $user->profile()->save(new Profile());
    }
}
