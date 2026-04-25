<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Apotik extends Model
{
    protected $table = 'e_apotik';

    protected $fillable = [
        'nama_apotek',
        'alamat',
        'no_telp',
        'email',
        'sip',
        'sia',
        'logo',
    ];
}
