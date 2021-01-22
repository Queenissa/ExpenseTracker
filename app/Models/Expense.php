<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'expense_amount', 'expense_date', 'expense_category' 
    ];

    protected $casts = [
        'expense_date' => 'date'  
    ];


    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
