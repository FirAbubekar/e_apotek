<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailReturnPembelian extends Model
{
    protected $table = 'detail_return_pembelian';

    protected $fillable = [
        'return_pembelian_id',
        'obat_id',
        'jumlah',
        'harga_satuan',
        'subtotal',
    ];

    public function header()
    {
        return $this->belongsTo(ReturnPembelian::class, 'return_pembelian_id');
    }

    public function obat()
    {
        return $this->belongsTo(Obat::class, 'obat_id');
    }
}
