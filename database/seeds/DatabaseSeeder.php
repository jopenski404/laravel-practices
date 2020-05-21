<?php

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
        //$this->call(UserSeeder::class);
        //$this->call(CitySeeder::class);
       
        $roles = [
          ['id' => 1, 'name' => 'Admin'],
          ['id' => 2, 'name' => 'User'],
          ['id' => 3, 'name' => 'Guest'],
      ];
      foreach($roles as $role){
        App\UserRoles::create($role);
    }
      //  factory(App\Cities::class,50)->create();
    }
}
