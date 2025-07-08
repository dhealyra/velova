<?php

namespace Database\Seeders;

use App\Models\DataKendaraan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DataKendaraanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['no_polisi' => 'D 1234 AB', 'jenis_kendaraan' => 'motor', 'nama_pemilik' => 'Rina', 'status_pemilik' => 'dokter'],
            ['no_polisi' => 'D 2345 CD', 'jenis_kendaraan' => 'mobil', 'nama_pemilik' => 'Bayu', 'status_pemilik' => 'staff'],
            ['no_polisi' => 'D 3456 EF', 'jenis_kendaraan' => 'motor', 'nama_pemilik' => 'Siti', 'status_pemilik' => 'suster'],
            ['no_polisi' => null, 'jenis_kendaraan' => 'sepeda', 'nama_pemilik' => null, 'status_pemilik' => 'tamu'],
            ['no_polisi' => 'D 5678 IJ', 'jenis_kendaraan' => 'mobil', 'nama_pemilik' => 'Lina', 'status_pemilik' => 'dokter'],
            ['no_polisi' => 'D 6789 KL', 'jenis_kendaraan' => 'motor', 'nama_pemilik' => 'Wawan', 'status_pemilik' => 'staff'],
            ['no_polisi' => 'D 7890 MN', 'jenis_kendaraan' => 'lainnya', 'nama_pemilik' => null, 'status_pemilik' => 'tamu'],
            ['no_polisi' => 'D 8901 OP', 'jenis_kendaraan' => 'mobil', 'nama_pemilik' => 'Joko', 'status_pemilik' => 'dokter'],
            ['no_polisi' => 'D 9012 QR', 'jenis_kendaraan' => 'motor', 'nama_pemilik' => 'Ani', 'status_pemilik' => 'suster'],
            ['no_polisi' => null, 'jenis_kendaraan' => 'sepeda', 'nama_pemilik' => null, 'status_pemilik' => 'tamu'],
        ];

        foreach ($data as $item) {
            DataKendaraan::create($item);
        }
    }
}
