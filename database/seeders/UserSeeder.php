<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin Toko',
            'email' => 'admin@toko.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Kasir Toko',
            'email' => 'kasir@toko.com',
            'password' => bcrypt('password'),
            'role' => 'kasir',
        ]);
    }
}
