<?php

namespace Database\Seeders;

use App\Models\KendaraanMasuk;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class KendaraanMasukSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $waktuMasuk = Carbon::now()->subMinutes(rand(60, 1000));

            KendaraanMasuk::create([
                'waktu_masuk' => $waktuMasuk,
                'id_kendaraan' => $i,
                'status_parkir' => 0,
                'created_at' => $waktuMasuk,
            ]);
        }
    }
}
