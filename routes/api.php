<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ExpenseGraphController;
use App\Http\Controllers\AdminController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Auth::user();

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Authenticated user
Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::put('/users/updateprofile', [UserController::class, 'updateUserProfile']);
    Route::get('/userexpenses', [ExpenseController::class, 'getExpenseOfUser']);   
    Route::get('/userexpenses/{id}', [ExpenseController::class, 'getExpenseOfUserById']);
    Route::get('/userexpensesbycategory', [ExpenseController::class, 'getExpenseOfUserByCategory']);
    Route::post('/expenses/add',[ExpenseController::class,'addValidatedUserExpenses']);
    Route::put('/expenses/update/{id}', [ExpenseController::class, 'updateUserExpenses']);
    Route::delete('/expenses/delete/{id}', [ExpenseController::class, 'deleteUserExpenses']);
    Route::get('/expensesbydate',[ExpenseController::class, 'expensesByDate']);

<<<<<<< HEAD
    // Route::get('/chart/yesterday',[ExpenseGraphController::class,'yesterdayChart']);
    // Route::get('/chart/week',[ExpenseGraphController::class,'weeklyChart']);
    // Route::get('/chart/month',[ExpenseGraphController::class,'monthlyChart']);
    // Route::get('/chart/year',[ExpenseGraphController::class,'yearlyChart']);
    // Route::get('/currentexpenses',[ExpenseController::class,'currentDayExpense']);
=======

    Route::get('/chart/yesterday',[ExpenseGraphController::class,'yesterdayChart']);
    Route::get('/chart/week',[ExpenseGraphController::class,'weeklyChart']);
    Route::get('/chart/month',[ExpenseGraphController::class,'monthlyChart']);
    Route::get('/chart/year',[ExpenseGraphController::class,'yearlyChart']);
    Route::get('/currentexpenses',[ExpenseController::class,'currentDayExpense']);
    Route::get('/expensesbydate',[ExpenseController::class,'expensesBydate']);
    Route::post('/expenserange',[ExpenseController::class,'byRange']);
>>>>>>> a7073e33a2065f68df76e2c1880f890377a00eb5


    Route::post('/logout', [UserController::class, 'logout']);
    

});


Route::post('/register', [UserController::class, 'register']);
Route::post('/login',[UserController::class,'login']);


 
//Admin
Route::get('/users', [AdminController::class, 'getAllUsers'] );
Route::get('/userexpenses/history/{id}', [AdminController::class, 'getUserExpensesHistory']);
Route::delete('/users/delete/{id}', [AdminController::class, 'deleteUser']);



//api
Route::get('/userslist', [UserController::class, 'usersList']);
Route::get('/expenseslist', [ExpenseController::class, 'expensesList']);
