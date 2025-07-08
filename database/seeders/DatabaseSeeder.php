<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            DataKendaraanSeeder::class,
            KendaraanMasukSeeder::class,
            KendaraanKeluarSeeder::class,
            KompensasiSeeder::class,
            PembayaranSeeder::class,
            KeuanganSeeder::class,
            UsersSeeder::class,
        ]);

    }
}
