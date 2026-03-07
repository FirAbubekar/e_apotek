<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
[
'role_name' => 'Admin',
'description' => 'Administrator'
],
[
'role_name' => 'Kasir',
'description' => 'Petugas Penjualan'
],
[
'role_name' => 'Gudang',
'description' => 'Petugas Gudang'
]
]);
    }
}
