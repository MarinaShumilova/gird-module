<?php



use GirdBase\database\seeds\AccessableIpSeeder;
use GirdBase\database\seeds\ModuleSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //регистрация модуля
        $this->call(ModuleSeeder::class);

        if(config('app.env') !== 'production') {
            $this->call(AccessableIpSeeder::class);   //разрешенные ip
//            $this->call(UsersSeeder::class);
            $this->call(RoleSeeder::class);             //роли/разрешения
        }

        $this->call(CommentsTableSeeder::class);



        $this->call(ContractorsTableSeeder::class);
        $this->call(CulpritsTableSeeder::class);
        $this->call(ExecutorsTableSeeder::class);
        $this->call(ExpensesTableSeeder::class);
        $this->call(ReasonsTableSeeder::class);
        $this->call(RegressesTableSeeder::class);

        $this->call(StatusesTableSeeder::class);
        $this->call(TypeCompsTableSeeder::class);
        $this->call(WarrantyDecreesTableSeeder::class);
        $this->call(WarrantyTypesTableSeeder::class);
        $this->call(ChassisTableSeeder::class);

        $this->call(ComplaintsTableSeeder::class);

        $this->call(ComplaintExecutorTableSeeder::class);


        $this->call(AddUsersSeeder::class);





    }
}
