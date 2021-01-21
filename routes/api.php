<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ExpenseGraphController;


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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::get('users', function(){
//     return User::all();
// });

// Route::get('users/{id}', function($id){
//     return User::find($id);
// }); 


// Route::post('users', function(Request $request){
//     return User::create($request->all);
// });

// Route::put('users/{id}', function(Request $request, $id){
//     $user = User::findOrFail($id);
//     $user = update($request->all());

//     return $user;
// });

// Route::delete('users/{id}', function($id){
//     User::find($id)->delete();  

//     return 204;
// });

Route::get('users', [UserController::class, 'index']);
Route::get('users/{id}', [UserController::class, 'show']);
Route::post('users', [UserController::class, 'store']);
Route::put('users/{id}', [UserController::class,'update']);
Route::delete('users/{id}', [UserController::class, 'delete']);
Route::post('/add-user', [UserController::class, 'insertRecord']);
Route::get('/get-user/{id}', [UserController::class, 'fetchExpenseByUser']);


Route::get('/expenses',[ExpenseController::class,'index']);
Route::get('/expenses/{id}', [ExpenseController::class, 'show']);
Route::post('/expenses',[ExpenseController::class,'store']);
Route::put('/expenses/{id}',[ExpenseController::class,'update']);
Route::get('/previousdayexpenses', [ExpenseController::class, 'previousDayExpense']);
Route::get('/expensesbycategory', [ExpenseController::class, 'groupExpense']);
Route::get('/expenseslastweek', [ExpenseController::class, 'last7DaysExpense']);
Route::get('/currentyearexpense', [ExpenseController::class, 'currentYearExpense']);
Route::get('/userexpense', [UserController::class, 'getUserExpense']);
Route::get('expenses/{id}/edit',[ExpenseController::class,'edit']);
Route::delete('expenses/{id}',[ExpenseController::class,'destroy']);

Route::get('/chart',[ExpenseGraphController::class,'index']);

