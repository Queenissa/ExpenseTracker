<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use DB;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Expense::all();
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'expense_amount'=>'required|numeric| max:500',
            // 'expense_date'=>'required',
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response     */
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        // $expense = Expense::find($id);
        
        // return response()->json($expense);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $expense = Expense::findOrFail($id);
        
        $validation = Validator::make($request->all(),[
            'expense_amount'=>'required|numeric| max:500',
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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


    public function previousDayExpense()
    {
        // $previousExpense = Expense::where('created_at','>=',Carbon::now()->subdays(1))->groupBy('expense_category')->sum('expense_amount');
        // return $previousExpense;

        $previousDayExpense = Expense::whereRaw("DAY(expense_date) = '" . Carbon::yesterday()->format('Y-m-d') . "'")->get('expense_category');
        return $previousDayExpense;
    }

    
    

    public function last7DaysExpense()
    {
        $previous_week = strtotime("-1 week +1 day");
        $start_week = strtotime("last sunday midnight",$previous_week);
        $end_week = strtotime("next saturday",$start_week);
        $start_week = date("Y-m-d",$start_week);
        $end_week = date("Y-m-d",$end_week);
       
        Expense::whereBetween('created_at', [$start_week, $end_week])->get(['expense_category','created_at']);

    }


    public function last30DaysExpense($id)
    {

    }


    //expenses in current year
    public function currentYearExpense()
    {
        $response =[];
        
        try{
            $currentyear = DB::table('expenses')->whereYear('expense_date', Carbon::now())->get()->groupBy('expense_category');
            $response['currentyear'] = $currentyear;
            $response['code'] = 200;

    }   catch(\Exception $e){
            $response["errors"] = "Record not found.";
            $response["code"] = 400;
    }

        return response($response, $response["code"]);
    }


    //expenses by category
    public function groupExpense()
    {
        $response = [];
        
         try{
            $expenses = DB::table('expenses')->get()->groupBy('expense_category');
            $response['expenses'] = $expenses;
            $response['code'] = 200;

    }   catch(\Exception $e){
            $response["errors"] = "Record not found.";
            $response["code"] = 400;
        }
        return response($response, $response['code']);
       
    }


   


}
