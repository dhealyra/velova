<?php

namespace Database\Seeders;

use App\Models\KendaraanKeluar;
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

        // Ambil semua kendaraan keluar + relasi masuk
        $kendaraanKeluars = KendaraanKeluar::with('kendaraanMasuk')->get();

        foreach ($kendaraanKeluars as $keluar) {
            // Cari kompensasi berdasar kendaraan keluar
            $kompensasi = Kompensasi::where('id_kendaraan_keluar', $keluar->id)->first();

            // Kalau ada kompensasi, ambil nilai denda
            $denda = $kompensasi ? $kompensasi->kompensasi_disetujui : 0;

            // Hitung total
            $total = $tarifParkir + $denda;

            // Pilih metode bayar
            $metode = $kompensasi ? 'gratis' : collect(['tunai', 'qrish'])->random();

            // Buat record pembayaran
            Pembayaran::create([
                'id_kendaraan_masuk' => $keluar->id_kendaraan_masuk,
                'id_kendaraan_keluar' => $keluar->id,
                'id_kompensasi' => $kompensasi?->id,
                'denda' => $denda > 0 ? $denda : null,
                'tarif' => $tarifParkir,
                'total' => $total,
                'pembayaran' => $metode,
            ]);
        }
    }


}
