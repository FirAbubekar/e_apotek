<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
'name' => 'Admin',
'email' => 'admin@apotek.com',
'password' => bcrypt('password'),
'role_id' => 1,
'is_active' => 1
]);
    }
}
