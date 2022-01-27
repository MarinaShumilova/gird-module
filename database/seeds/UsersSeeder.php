<?php

use GirdBase\Models\Module;
use App\Models\Profile;
use GirdBase\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'username',
            'email' => 'em@em',
            'password' => Hash::make('123')
        ]);

        // обязательное условие для пользования модулем
        $user->modules()->attach(Module::where('name', config('app.name'))->first());
        $user->profile()->save(new Profile());
    }
}
