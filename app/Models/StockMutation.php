<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMutation extends Model
{
    use HasFactory;

    protected $fillable = [
        'medicine_stock_id',
        'type',
        'qty_change',
        'qty_before',
        'qty_after',
        'reference',
        'user_id',
        'notes',
    ];

    public function medicineStock()
    {
        return $this->belongsTo(MedicineStock::class, 'medicine_stock_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
