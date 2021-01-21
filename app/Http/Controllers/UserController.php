<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Expense;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::all();
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
        //
        $request->validate([
            'firstname'=>'required',
            'lastname'=>'required',
            'email'=>'required',
            'password'=>'required'
        ]);

        $user = User::create($request->all());

        return response()->json($user);

        // $user = new User([
        //     'firstname'=>$request->get('firstname'),
        //     'lastname'=>$request->get('lastname'),
        //     'email'=>$request->get('email'),
        //     'password'=>$requets->get('password')
        // ]);

        // $user->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        return User::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $user  = User::findOrFail($id);
        $user->update($request->all());

        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request,$id)
    {
        //
        $user = User::findOrFail($id);
        $user->delete();

        return 204;

    }


    public function insertRecord(Request $request)
    {
        $expense = new Expense();

        $expense->expense_amount = $request->get('expense_amount');
        $expense->expense_date = $request->get('expense_date');
        $expense->expense_category= $request->get('expense_category');
        $user = new User();
        $user->firstname = $request->get('firstname');
        $user->lastname = $request->get('lastname');
        $user->email = $request->get('email');
        $user->password = encrypt($request->get('password'));
        $user->save();
        $user->expense()->save($expense);

        return "Record has been created";
    }


    public function fetchExpenseByUser($id){
        
        $response = [];
        try{
            $expense = User::findOrFail($id)->expense;
        } catch(\Exception $e){
            $response["errors"] = "ID not found";
            $response["code"] = 400;
        }
        
        return response()->json($expense);
    }


 }



    
}