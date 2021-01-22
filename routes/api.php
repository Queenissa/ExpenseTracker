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
Auth::user();

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::put('/users/updateprofile', [UserController::class, 'updateUserProfile']);
    Route::get('/userexpenses', [ExpenseController::class, 'getExpenseOfUser']);  
    Route::get('/userexpenses/{id}', [ExpenseController::class, 'getExpenseOfUserById']);
    Route::get('/userexpensesbycategory', [ExpenseController::class, 'getExpenseOfUserByCategory']);
    Route::post('/expenses/add', [ExpenseController::class, 'addUserExpenses']);
    Route::put('/expenses/update/{id}', [ExpenseController::class, 'updateUserExpenses']);
    Route::delete('/expenses/delete/{id}', [ExpenseController::class, 'deleteUserExpenses']);
    Route::post('/logout', [UserController::class, 'logout']);

});


Route::post('/register', [UserController::class, 'register']);
Route::post('/login',[UserController::class,'login']);


Route::get('/chart',[ExpenseGraphController::class,'index']);

