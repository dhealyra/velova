<?php

namespace Database\Seeders;

use App\Models\KendaraanMasuk;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KendaraanMasukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $waktuMasuk = Carbon::now()->subMinutes(rand(1, 1000));
            KendaraanMasuk::create([
                'waktu_masuk' => $waktuMasuk,
                'id_kendaraan' => $i, // Pastikan data_kendaraans punya ID 1-10
                'status_parkir' => rand(0, 1),
                'created_at' => $waktuMasuk,
            ]);
        }
    }
}
