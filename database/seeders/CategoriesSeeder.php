<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
[
'category_code'=>'OBT',
'category_name'=>'Obat Tablet'
],
[
'category_code'=>'SYR',
'category_name'=>'Obat Sirup'
],
[
'category_code'=>'CAP',
'category_name'=>'Kapsul'
]
]);
    }
}
