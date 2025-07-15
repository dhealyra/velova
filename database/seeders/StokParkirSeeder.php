<?php

namespace Database\Seeders;

use App\Models\StokParkir;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StokParkirSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statusPemilikList = ['tamu', 'staff'];
        $jenisKendaraanList = ['mobil', 'motor', 'sepeda', 'lainnya'];

        foreach ($statusPemilikList as $status) {
            foreach ($jenisKendaraanList as $jenis) {
                StokParkir::create([
                    'status_pemilik' => $status,
                    'jenis_kendaraan' => $jenis,
                    'kapasitas' => rand(10, 100),
                    'sisa_slot' => rand(0, 10),
                ]);
            }
        }
    }
}
