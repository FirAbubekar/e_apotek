<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MedicinesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=1;$i<=20;$i++) {

DB::table('medicines')->insert([
'medicine_code'=>'OBT'.str_pad($i,4,'0',STR_PAD_LEFT),
'barcode'=>rand(1000000000,9999999999),
'medicine_name'=>'Obat '.$i,
'category_id'=>1,
'unit_id'=>1,
'supplier_id'=>1,
'purchase_price'=>1000,
'selling_price'=>1500,
'minimum_stock'=>10,
'is_active'=>1
]);

}
    }
}
