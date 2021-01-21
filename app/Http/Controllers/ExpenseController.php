<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use Illuminate\Support\Facades\Validator;

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
                'before_or_equal:'. now()->format('Y-m-d')
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
        }catch(\Exception $e){
            $response["errors"] = "Expense not found.";
            $response["code"] = 400;
        }
        return response($response, $response["code"]);

       
    }
}
