<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashTransaction extends Model
{
    use HasFactory;

    protected $table = 'cash_transactions';

    protected $fillable = [
        'no_transaksi',
        'type',
        'category',
        'amount',
        'description',
        'transaction_date',
        'reference_type',
        'reference_id',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
