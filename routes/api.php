<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExpenseController;

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

Route::get('/expenses',[ExpenseController::class,'index']);
Route::post('/expenses',[ExpenseController::class,'store']);
Route::put('/expenses/{id}',[ExpenseController::class,'update']);
Route::get('expenses/{id}',[ExpenseController::class,'show']);

