<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Expense;
use App\Http\Controllers;
use Resources\Views;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class ExpenseGraphController extends Controller
{
   
    //method for showing the expenses in previous day of specific user in the pie graph
    public function yesterdayChart()
    {   
        $user = Auth::user();
        $data = Expense::select(
            DB::raw('expense_category as category'),
            DB::raw('sum(expense_amount) as number'))
            ->where('user_id', $user->id)
            ->where('expense_date' ,now()->yesterday())
           ->groupBy('category')
           ->get();
      
        $array[] = ['Category', 'Number'];

        foreach($data as $key => $value)
        {
          $array[++$key] = [$value->category, $value->number];
        }

        return view('yesterday')->with('category', json_encode($array));
    }


    

    //method for showing the expenses in the current week of specific user in the pie graph
    public function weeklyChart()
    {

        $user = Auth::user();
        $data = Expense::select(
            DB::raw('expense_category as category'),
            DB::raw('sum(expense_amount) as number'))
            ->where('user_id', $user->id)
            ->where('expense_date','>', now()->subDays(7))
           ->groupBy('category')
           ->get();

        //    dd($data);
      
        $array[] = ['Category', 'Number'];

        foreach($data as $key => $value)
        {
          $array[++$key] = [$value->category, $value->number];
        }

        return view('lastWeek')->with('category', json_encode($array));
    }




    //method for showing the expenses by current month of specific user in the pie graph
    public function monthlyChart()
    {
      $user = Auth::user();
        $data = Expense::select(
            DB::raw('expense_category as category'),
            DB::raw('sum(expense_amount) as number'))
            ->where('user_id', $user->id)
            ->where('expense_date','>', now()->subMonth())
           ->groupBy('category')
           ->get();

        //    dd($data);
      
        $array[] = ['Category', 'Number'];

        foreach($data as $key => $value)
        {
          $array[++$key] = [$value->category, $value->number];
        }

        return view('lastMonth')->with('category', json_encode($array));
    }




    //method for showing the expenses in the current year of specific user in the pie graph
    public function yearlyChart()
    {

      $user = Auth::user();
        $data = Expense::select(
            DB::raw('expense_category as category'),
            DB::raw('sum(expense_amount) as number'))
            ->where('user_id', $user->id)
            ->where('expense_date','>', now()->subYear())
           ->groupBy('category')
           ->get();

        //    dd($data);
      
        $array[] = ['Category', 'Number'];

        foreach($data as $key => $value)
        {
          $array[++$key] = [$value->category, $value->number];
        }

        return view('year')->with('category', json_encode($array));
    }

}
