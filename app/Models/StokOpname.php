<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokOpname extends Model
{
    protected $table = 'stok_opnames';

    protected $fillable = [
        'tanggal_opname',
        'keterangan',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function detail()
    {
        return $this->hasMany(DetailStokOpname::class, 'stok_opname_id');
    }
}
