<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Expense;
use App\Http\Controllers;
use Resources\Views;
use Carbon\Carbon;


class ExpenseGraphController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function yesterdayChart()
    {   
        $data = Expense::select(
            DB::raw('expense_category as category'),
            DB::raw('sum(expense_amount) as number'))
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


    public function weeklyChart()
    {

        $data = Expense::select(
            DB::raw('expense_category as category'),
            DB::raw('sum(expense_amount) as number'))
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


    public function monthlyChart()
    {

        $data = Expense::select(
            DB::raw('expense_category as category'),
            DB::raw('sum(expense_amount) as number'))
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

    
    public function yearlyChart()
    {

        $data = Expense::select(
            DB::raw('expense_category as category'),
            DB::raw('sum(expense_amount) as number'))
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
