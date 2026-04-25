<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashierClosing extends Model
{
    protected $fillable = [
        'user_id',
        'opening_time',
        'closing_time',
        'opening_cash',
        'total_cash_sales',
        'total_non_cash_sales',
        'total_income',
        'total_expense',
        'expected_cash',
        'actual_cash',
        'difference',
        'notes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
