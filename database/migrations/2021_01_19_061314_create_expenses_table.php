<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->double('expense_amount',9,2);
            $table->date('expense_date');
            $table->enum('expense_category',[
                "Food",
                "Savings",
                "Water",
                "Phone",
                "Clothing",
                "Electricity",
                "Personal Care",
                "Transportation",
                "Others"]);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expenses');
        $table->dropForeign('expenses_user_id_foreign');
        $table->dropIndex('expenses_user_id_index');
        $table->dropColumn('user_id');
        
    }
}
