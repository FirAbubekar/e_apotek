<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailReturnPenjualan extends Model
{
    protected $table = 'detail_return_penjualan';

    protected $fillable = [
        'return_penjualan_id',
        'obat_id',
        'jumlah',
        'harga_satuan',
        'subtotal',
    ];

    public function header()
    {
        return $this->belongsTo(ReturnPenjualan::class, 'return_penjualan_id');
    }

    public function obat()
    {
        return $this->belongsTo(Obat::class, 'obat_id');
    }
}
