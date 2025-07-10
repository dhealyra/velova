<?php

namespace Database\Seeders;

use App\Models\KendaraanKeluar;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KompensasiSeeder extends Seeder
    {
        public function run()
        {
            $kendaraanRusak = KendaraanKeluar::where('status_kondisi', '!=', 'baik')->get();

            foreach ($kendaraanRusak as $keluar) {
                DB::table('kompensasis')->insert([
                    'id_kendaraan_keluar' => $keluar->id,
                    'jenis_kompensasi' => $this->getJenisKompensasi($keluar->sebab_denda),
                    'tipe_kompensasi' => fake()->boolean(),
                    'kompensasi_disetujui' => $this->hitungKompensasi($keluar->sebab_denda),
                    'nama_pemilik' => fake()->name(),
                    'keterangan' => 'Kerusakan karena ' . $keluar->sebab_denda,
                    'status_pengajuan' => 'pending',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        private function getJenisKompensasi(string $sebab): string
        {
            return match ($sebab) {
                'kehilangan' => 'kehilangan',
                default => 'rusak',
            };
        }

        private function hitungKompensasi(string $sebab): float
        {
            return match ($sebab) {
                'tiket hilang' => 25000.00,
                'merusak' => 125000.00,
                'kehilangan' => 200000.00,
                default => 0,
            };
        }
    }
