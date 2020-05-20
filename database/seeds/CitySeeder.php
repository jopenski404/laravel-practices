<?php


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

     
        factory(App\Cities::class,10)->create();


     /*    DB::table('cities')->insert([
            'name' => Str::random(10)
        ]); */
    }
}
