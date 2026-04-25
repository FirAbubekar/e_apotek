<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReturnPembelian extends Model
{
    protected $table = 'return_pembelian';

    protected $fillable = [
        'no_return',
        'pembelian_id',
        'user_id',
        'tanggal_return',
        'total_return',
        'alasan',
    ];

    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class, 'pembelian_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function details()
    {
        return $this->hasMany(DetailReturnPembelian::class, 'return_pembelian_id');
    }
}
