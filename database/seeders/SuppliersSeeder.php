<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SuppliersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('suppliers')->insert([
[
'supplier_code'=>'SUP001',
'supplier_name'=>'Kimia Farma'
],
[
'supplier_code'=>'SUP002',
'supplier_name'=>'Kalbe Farma'
]
]);
    }
}
