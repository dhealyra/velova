<?php

namespace Database\Seeders;

use App\Models\KendaraanKeluar;
use App\Models\KendaraanMasuk;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KendaraanKeluarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kendaraanMasuks = KendaraanMasuk::take(4)->get();

        foreach ($kendaraanMasuks as $masuk) {
            $waktuMasuk = Carbon::parse($masuk->waktu_masuk);
            $waktuKeluar = $waktuMasuk->copy()->addMinutes(rand(10, 180)); // Random antara 10–180 menit

            KendaraanKeluar::create([
                'id_kendaraan_masuk' => $masuk->id,
                'waktu_keluar' => $waktuKeluar,
                'status_kondisi' => ['baik', 'tiket hilang', 'rusak', 'merusak', 'kehilangan'][rand(0, 4)],
            ]);
        }
    }
}
