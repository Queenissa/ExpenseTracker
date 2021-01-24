<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Expense;
use DB;

class AdminController extends Controller
{
    

    //method for getting all the users
    public function getAllUsers()
    {
        $users = User::all();
        return $users;
    }



    //method for getting/viewing expenses history of specific user
    public function getUserExpensesHistory(Request $request, $id)
    {

        $response = [];

        try{
            $userExpensesHistory = Expense::Where('user_id', $id)
            ->groupBy('expense_category')  
            ->select([DB::raw("SUM(expense_amount) as total_amount, expense_category")])
            ->pluck('total_amount', 'expense_category');
            $response["code"] = 200;
            $response["userExpensesHistory"] = $userExpensesHistory;
          
          
        }
        catch(\Expense $e){
            $response["error"] = "Record not found.";
            $response["code"] = 400;
        }
        return response($response, $response["code"]);
    }



    //method for deleting user and his/her expenses
    public function deleteUser(Request $request, $id)
    {
        $response = [];

        try{
            $user = DB::table('expenses')->where('user_id', $id )->delete();
            $response["code"] = 200;
            $response["message"] = "Record has been deleted";
        }
        catch(\Exception $e)
        {
            $response["error"] = "Expense not found.";
            $response["code"] = 400;
        }
        
        return response($response, $response['code']);
     
    
    }

}
