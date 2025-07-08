<?php

namespace Database\Seeders;

use App\Models\Kompensasi;
use App\Models\Pembayaran;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PembayaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tarifParkir = 5000;

        $data = [
            [
                'id_kendaraan_masuk' => 1,
                'id_kendaraan_keluar' => 1,
                'id_kompensasi' => null,
                'pembayaran' => 'tunai',
            ],
            [
                'id_kendaraan_masuk' => 2,
                'id_kendaraan_keluar' => 2,
                'id_kompensasi' => 1, // kompensasi tiket hilang 50rb
                'pembayaran' => 'gratis',
            ],
            [
                'id_kendaraan_masuk' => 3,
                'id_kendaraan_keluar' => 3,
                'id_kompensasi' => null,
                'pembayaran' => 'qrish',
            ],
            [
                'id_kendaraan_masuk' => 4,
                'id_kendaraan_keluar' => 4,
                'id_kompensasi' => 2, // kompensasi kehilangan 150rb
                'pembayaran' => 'gratis',
            ],
        ];

        foreach ($data as $item) {
            $kompensasi = $item['id_kompensasi']
                ? Kompensasi::find($item['id_kompensasi'])->jumlah
                : 0;

            $total = $item['id_kompensasi']
                ? -$kompensasi     // Jika ada kompensasi, total = negatif kompensasi
                : $tarifParkir;    // Jika tidak ada kompensasi, bayar parkir biasa

            Pembayaran::create([
                'id_kendaraan_masuk' => $item['id_kendaraan_masuk'],
                'id_kendaraan_keluar' => $item['id_kendaraan_keluar'],
                'id_kompensasi' => $item['id_kompensasi'],
                'total' => $total,
                'pembayaran' => $item['pembayaran'],
            ]);
        }
    }
}
