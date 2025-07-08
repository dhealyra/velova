<?php

namespace Database\Seeders;

use App\Models\Kompensasi;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KompensasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run()
    {
        DB::table('kompensasis')->insert([
            [
                'id_kendaraan_keluar' => 1,
                'tingkat_kerusakan' => 'ringan',
                'kompensasi_disetujui' => 25000.00,
                'nama_pemilik' => 'Rizky Hidayat',
                'keterangan' => 'Spion patah, tapi bisa dibetulin manual',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_kendaraan_keluar' => 2,
                'tingkat_kerusakan' => 'berat',
                'kompensasi_disetujui' => 150000.50,
                'nama_pemilik' => 'Ayu Lestari',
                'keterangan' => 'Body lecet parah & lampu pecah',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
