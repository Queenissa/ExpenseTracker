<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use DB;

class ExpenseController extends Controller
{
    public function index()
    {
        return Expense::all();
        
    }


    public function store(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'expense_amount'=>'required|numeric| max:1000',
            'expense_date'=>[
                'required',
                'before_or_equal:'. now()->format('Y-m-d')
            ],
            'expense_category'
        ]);

        if($validation->fails()) {
            return $validation->errors();
        }
        $expenses= Expense::create($request->all());

        return response()->json($expenses);
    }

    public function show($id)
    {
        $response = [];

        try{
            $expense = Expense::findOrFail($id);
            $response["code"] = 200;
            $response["expense"] = $expense;

        }catch(\Exception $e){
            $response["errors"] = "Expense not found." .$e;
            $response["code"] = 400;
        }

        return response($response, $response["code"]);

    }

    
    public function update(Request $request,$id)
    {
        $expense = Expense::findOrFail($id);
        
        $validation = Validator::make($request->all(),[
            'expense_amount'=>'required|numeric| max:1000',
            'expense_date'=>[
                'required',
                'before_or_equal:'.Carbon::now()->format('Y-m-d')
            ],
            'expense_category'
        ]);

        if($validation->fails()) {
            return $validation->errors();
        }

        $expense = Expense::findOrFail($id);
        $expense->update([
            'expense_amount'=> $request->expense_amount,
            'expense_date'=>$request->expense_date,
            'expense_category'=>$request->expense_category
        ]);
        $expense->save();

        return response()->json($expense);
    }

   
    public function destroy($id)
    {
        $response = [];

        try{
            $expense = Expense::findOrFail($id);
            $response["code"] = 200;
            $response["expense"] = $expense;
            $result = $expense->delete();

            if($result)
            {
                return ["message"=>"Record has been deleted"];
            }
        }catch(\Exception $e)
        {
            $response["errors"] = "Expense not found.";
            $response["code"] = 400;
        }

        return response($response, $response["code"]);

       
    } 

    //expenses in a day
    public function currentDayExpense(){
        $data = Expense::select(
        DB::raw('sum(expense_amount) as number'))
        ->where('expense_date','=', now()->toDateString())
       ->sum('expense_amount');

    //    dd($data);
    return response()->json($data);
  
}
    }


    


