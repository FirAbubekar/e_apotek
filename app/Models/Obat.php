<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    protected $table = 'medicines';

    protected $fillable = [
        'medicine_code',
        'barcode',
        'medicine_name',
        'category_id',
        'unit_id',
        'supplier_id',
        'purchase_price',
        'selling_price',
        'minimum_stock',
        'description',
        'is_active',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriObat::class, 'category_id');
    }

    public function satuan()
    {
        return $this->belongsTo(Satuan::class, 'unit_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function stok()
    {
        return $this->hasOne(StokObat::class, 'obat_id');
    }
}
