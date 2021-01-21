<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Database\Seeders\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'firstname' => Str::random(15),
            'lastname' => Str::random(15),
            'email' => Str::random(10).'@gmail.com',
            'is_admin' => 1,
            'password' => Hash::make('password'),
        ]);
    }
}
