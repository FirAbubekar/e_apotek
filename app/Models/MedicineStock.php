<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicineStock extends Model
{
    protected $table = 'medicine_stocks';

    protected $fillable = [
        'medicine_id',
        'batch_id',
        'stock_qty',
        'stock_in',
        'stock_out',
        'last_stock',
        'created_by',
        'updated_by',
    ];

    public function obat()
    {
        return $this->belongsTo(Obat::class, 'medicine_id');
    }

    public function batch()
    {
        return $this->belongsTo(MedicineBatch::class, 'batch_id');
    }
}
