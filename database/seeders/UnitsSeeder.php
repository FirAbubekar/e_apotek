<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('units')->insert([
['unit_code'=>'PCS','unit_name'=>'PCS'],
['unit_code'=>'BOX','unit_name'=>'BOX'],
['unit_code'=>'BOT','unit_name'=>'BOTOL']
]);
    }
}
