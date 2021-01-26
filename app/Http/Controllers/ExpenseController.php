<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;

class ExpenseController extends Controller
{
   

      //add validated expenses
      public function addValidatedUserExpenses(Request $request)
      {
  
          $user = Auth::user();
          $validation = Validator::make($request->all(),[
               'expense_amount'=>'required|numeric| max:1000',
               'expense_date'=>[
                   'required',
                   'before_or_equal:'. now()->format('Y-m-d')
               ],
               'expense_category'
           ]);
          
          if($validation) {
  
              $expenses = Expense::where('user_id', $user->id)->where('expense_date','=',now()->toDateString())->get()->sum('expense_amount');
              $amount = 1000;
  
              if($expenses < $amount){
                  $expense = new Expense();
                  $expense->user_id = $user->id;
                  $expense->expense_amount = $request->expense_amount;
                  $expense->expense_date = $request->expense_date;
                  $expense->expense_category = $request->expense_category;
                  $response = $expense->save();
  
                  return response()->json($expense);
              }
              else
              {
                  return 'Unable to add!. You have reach the limit amount!';
              }
          }
          else
          {
              return $validation->errors();
          }
      }


    


    //method for deleting expense of specific user
    public function deleteUserExpenses(Request $request, $id)
    {
        $user = Auth::user();
        $response = [];

        try{
            $userId = DB::table('expenses')->where('user_id', $user->id)->where('id', $id)->delete();
            $response["code"] = 200;
            $response["message"] = "Record has been deleted";
           
        }catch(\Exception $e){
            $response["error"] = "Expense not found.";
            $response["code"] = 400;
        }

        return response($response, $response["code"]);
       
    }




   //method for updating expense of specific user
    public function updateUserExpenses(Request $request, $id)
    {
        $user = Auth::user();
        $response = [];
        try{
            $update = DB::table('expenses')->where('user_id', $user->id)->where('id', $id)->update([
                'expense_amount'=> $request->expense_amount,
                'expense_date'=>$request->expense_date,
                'expense_category'=>$request->expense_category
            ]);

            $response["message"] = "Record has been updated";
            $response["code"] = 200;
           
        }
        catch(\Exception $e){
            $response["error"] = "Record not found. $e";
            $response["code"] = 400;
        }
        return response($response, $response['code']);
    }




    //method for getting expenses of specific user by category
    public function getExpenseOfUserByCategory(Request $request)
    {
       $user = Auth::user();
       $response = [];
        try{
            $userExpense = DB::table('expenses')->where('user_id', $user->id)->get()->groupBy('expense_category');
            $response['userExpense'] = $userExpense;
            $response['code'] = 200;
       }
        catch(\Exception $e){
            $response["error"] = "Record not found.";
            $response["code"] = 400;
       }
        return response($response, $response['code']);
    }




    //method for getting expenses of specific user
    public function getExpenseOfUser(Request $request)
    {
        $user = Auth::user();
        $response = [];
        try{
            $userExpense = DB::table('expenses')->where('user_id', $user->id)->get();
            $response['userExpense'] = $userExpense;
            $response['code'] = 200;
       }
        catch(\Exception $e){
            $response["error"] = "Record not found.";
            $response["code"] = 400;
       }
        return response($response, $response['code']);
    }




    //method for getting specific expense of specific  user expense id
    public function getExpenseOfUserById(Request $request, $id)
    {
        $user = Auth::user();
        $response = [];
        try{
            $userExpense = DB::table('expenses')->where('user_id', $user->id)->where('id', $id)->get();
            $response['userExpense'] = $userExpense;
            $response['code'] = 200;
       }
        catch(\Exception $e){
            $response["error"] = "Record not found.";
            $response["code"] = 400;
       }
        return response($response, $response['code']);
    }




    public function expensesList()
    {
        $expenses = Expense::all();
        return $expenses;
    }


    //method for showing all expenses categorized by date

    public function expensesByDate(Request $request, $id)
    {
           $user = Auth::user();
           $response = [];
            try{
               
                $userExpense = DB::table('expenses')
                ->where('user_id', $user->id)->where('id'->$id)->groupBy('expense_date')->get();

                dd($userExpense);

                $response['userExpense'] = $userExpense;
                $response['code'] = 200;
           }
            catch(\Exception $e){
                $response["error"] = "Record not found.";
                $response["code"] = 400;
           }
            return response($response, $response['code']);
    
    }
}


