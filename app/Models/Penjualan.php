<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $table = 'penjualan';

    protected $fillable = [
        'no_transaksi',
        'pelanggan_id',
        'user_id',
        'tanggal_penjualan',
        'subtotal',
        'diskon',
        'ppn',
        'tipe_penjualan',
        'metode_pembayaran',
        'dokter',
        'no_resep',
        'total_harga',
        'bayar',
        'kembali',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Customer::class, 'pelanggan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function detailPenjualan()
    {
        return $this->hasMany(DetailPenjualan::class, 'penjualan_id');
    }
}
