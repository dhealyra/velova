<?php

namespace Database\Seeders;

use App\Models\Keuangan;
use App\Models\Pembayaran;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KeuanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pembayarans = Pembayaran::all();

        foreach ($pembayarans as $bayar) {
            Keuangan::create([
                'jumlah' => $bayar->total,
                'id_pembayaran' => $bayar->id,
                'waktu_transaksi' => $bayar->created_at, // biar konsisten
            ]);
        }
    }

}
