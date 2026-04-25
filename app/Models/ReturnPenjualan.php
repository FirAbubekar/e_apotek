<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReturnPenjualan extends Model
{
    protected $table = 'return_penjualan';

    protected $fillable = [
        'no_return_pj',
        'penjualan_id',
        'user_id',
        'tanggal_return',
        'total_return',
        'alasan',
    ];

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'penjualan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function details()
    {
        return $this->hasMany(DetailReturnPenjualan::class, 'return_penjualan_id');
    }
}
