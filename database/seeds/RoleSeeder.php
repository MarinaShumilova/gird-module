<?php

use Illuminate\Database\Seeder;
use GirdBase\Models\Module;
use App\Models\Role;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::create([
            'name' => 'admin',
            'display_name' => 'Администратор',


        ]);

        $user = Role::create([
            'name' => 'user',
            'display_name' => 'Пользователь',

        ]);



    }
}
