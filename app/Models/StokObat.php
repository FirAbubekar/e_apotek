<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokObat extends Model
{
    protected $table = 'stok_obat';

    protected $fillable = [
        'obat_id',
        'jumlah_stok',
        'tanggal_kadaluarsa',
    ];

    public function obat()
    {
        return $this->belongsTo(Obat::class, 'obat_id');
    }
}
