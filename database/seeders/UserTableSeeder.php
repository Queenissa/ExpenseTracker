<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // User::truncate();

        $faker = \Faker\Factory::create();


        for($i=0; $i<50; $i++){
            User::create([
                'firstname'=>$faker->firstname,
                'lastname'=>$faker->lastname,
                'email'=>$faker->email,
                'password'=>$faker->password
            ]);
        }
    }
}
