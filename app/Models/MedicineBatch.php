<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicineBatch extends Model
{
    protected $table = 'medicine_batches';

    protected $fillable = [
        'medicine_id',
        'pembelian_id',
        'batch_number',
        'expired_date',
        'purchase_price',
        'selling_price',
        'created_by',
        'updated_by',
    ];

    public function obat()
    {
        return $this->belongsTo(Obat::class, 'medicine_id');
    }

    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class, 'pembelian_id');
    }

    public function stocks()
    {
        return $this->hasMany(MedicineStock::class, 'batch_id');
    }
}
