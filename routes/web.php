<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExpenseGraphController;
use App\Http\Controllers\ExpenseController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/chart/yesterday',[ExpenseGraphController::class,'yesterdayChart'])->name('views.yesterday');
Route::get('/chart/week',[ExpenseGraphController::class, 'weeklyChart'])->name('views.lastWeek');
Route::get('/chart/month',[ExpenseGraphController::class,'monthlyChart'])->name('views.lastMonth');
Route::get('/chart/year',[ExpenseGraphController::class,'yearlyChart'])->name('views.year');
Route::get('/currentexpenses',[ExpenseController::class,'currentDayExpense']);