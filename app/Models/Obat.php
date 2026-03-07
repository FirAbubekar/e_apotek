<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    protected $table = 'obat';

    protected $fillable = [
        'kode_obat',
        'nama_obat',
        'kategori_id',
        'satuan_id',
        'harga_beli',
        'harga_jual',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriObat::class, 'kategori_id');
    }

    public function satuan()
    {
        return $this->belongsTo(Satuan::class, 'satuan_id');
    }

    public function stok()
    {
        return $this->hasOne(StokObat::class, 'obat_id');
    }
}
