<?php

namespace Database\Seeders;

use App\Models\KendaraanKeluar;
use App\Models\KendaraanMasuk;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class KendaraanKeluarSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil 5 kendaraan yg masih parkir
        $masuks = KendaraanMasuk::where('status_parkir', 0)->take(5)->get();

        foreach ($masuks as $masuk) {
            $waktuKeluar = Carbon::parse($masuk->waktu_masuk)->addMinutes(rand(30, 180));

            // Status kondisi random
            $kondisi = ['baik', 'rusak', 'kehilangan'][rand(0, 2)];
            $sebabDenda = $kondisi === 'baik' ? 'tiket hilang' : ['tiket hilang', 'merusak', 'lainnya'][rand(0, 2)];

            KendaraanKeluar::create([
                'id_kendaraan_masuk' => $masuk->id,
                'waktu_keluar' => $waktuKeluar,
                'status_kondisi' => $kondisi,
                'sebab_denda' => $sebabDenda,
            ]);

            // Update status parkir jadi 1 (keluar)
            $masuk->update(['status_parkir' => 1]);
        }
    }
}
