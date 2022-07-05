<?php

use App\Models\Permission;
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
        $complaintCreate = Permission::create(['name' => 'complaint.create', 'display_name' => 'Создать комплайн']);
        $complaintDelete = Permission::create(['name' => 'complaint.destroy', 'display_name' => 'Удалить комплайн']);
        $complaintIndex = Permission::create(['name' => 'complaint.index', 'display_name' => 'Отобразить комплайн']);
        $complaintStore = Permission::create(['name' => 'complaint.store', 'display_name' => 'Сохранить комплайн']);
        $complaintShow = Permission::create(['name' => 'complaint.show', 'display_name' => 'Отобразить информацию']);
        $complaintEdit = Permission::create(['name' => 'complaint.edit', 'display_name' => 'Редактировать комплайн']);



        $admin = Role::create([
            'name' => 'admin',
            'display_name' => 'Администратор',
        ])->attachPermissions([
            $complaintCreate,
            $complaintDelete,
            $complaintIndex,
            $complaintStore,
            $complaintShow,
            $complaintEdit,

        ]);

        $user = Role::create([
            'name' => 'user',
            'display_name' => 'Пользователь',
        ])->attachPermissions([
            $complaintIndex,
            $complaintShow,
        ]);

        $account = Role::create([
            'name' => 'account',
            'display_name' => 'Бухгалтерия',
        ])->attachPermissions([
            $complaintIndex,
            $complaintShow,
        ]);








    }
}
