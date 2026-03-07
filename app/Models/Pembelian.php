<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    protected $table = 'pembelian';

    protected $fillable = [
        'no_faktur',
        'supplier_id',
        'user_id',
        'tanggal_pembelian',
        'total_harga',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function detailPembelian()
    {
        return $this->hasMany(DetailPembelian::class, 'pembelian_id');
    }
}
