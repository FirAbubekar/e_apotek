<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriObat extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'category_code',
        'category_name',
        'description',
    ];

    public function obat()
    {
        return $this->hasMany(Obat::class, 'kategori_id');
    }
}
