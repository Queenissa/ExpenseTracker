<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Expense;

class ExpensetableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Expense::truncate();
        Expense::factory(10)->create();
    }
}
