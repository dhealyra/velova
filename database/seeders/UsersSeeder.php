<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
            'role' => 1,
        ]);

        // Petugas
        User::create([
            'name' => 'petugas',
            'email' => 'petugas@example.com',
            'password' => Hash::make('petugas123'),
            'role' => 0,
        ]);
    }
}
