<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Satuan extends Model
{
    protected $table = 'units';

    protected $fillable = [
        'unit_code',
        'unit_name',
        'description',
    ];

    public function obat()
    {
        return $this->hasMany(Obat::class, 'satuan_id');
    }
}
