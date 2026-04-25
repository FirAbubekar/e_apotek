<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailStokOpname extends Model
{
    protected $table = 'detail_stok_opnames';

    protected $fillable = [
        'stok_opname_id',
        'medicine_stock_id',
        'stok_sistem',
        'stok_fisik',
        'selisih',
        'alasan',
    ];

    public function stokOpname()
    {
        return $this->belongsTo(StokOpname::class, 'stok_opname_id');
    }

    public function medicineStock()
    {
        return $this->belongsTo(MedicineStock::class, 'medicine_stock_id');
    }
}
