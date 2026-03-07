<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Satuan extends Model
{
    protected $table = 'satuan';

    protected $fillable = [
        'nama_satuan',
        'keterangan',
    ];

    public function obat()
    {
        return $this->hasMany(Obat::class, 'satuan_id');
    }
}
