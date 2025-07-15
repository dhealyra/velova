<?php

namespace App\Http\Controllers;

use App\Models\DataKendaraan;
use App\Models\KendaraanKeluar;
use App\Models\KendaraanMasuk;
use App\Models\Kompensasi;
use App\Models\Pembayaran;
use App\Models\StokParkir;
use App\Models\TransaksiParkir;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $today = now();

        $total = DataKendaraan::count();

        // Masuk & keluar hari ini
        $masukHariIni = KendaraanMasuk::whereDate('waktu_masuk', $today)->count();
        $keluarHariIni = KendaraanKeluar::whereDate('waktu_keluar', $today)->count();

        $rusak = KendaraanKeluar::where('status_kondisi', 'rusak')->count();
        $hilang = KendaraanKeluar::where('status_kondisi', 'hilang')->count();

        $stokParkir = StokParkir::sum('sisa_slot');

        $jenis = DataKendaraan::select('jenis_kendaraan')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('jenis_kendaraan')
            ->pluck('total', 'jenis_kendaraan');

        $pendapatan = Pembayaran::sum('total');
        $targetPendapatan = 10000000;
        $persenPendapatan = $targetPendapatan > 0 ? min(100, ($pendapatan / $targetPendapatan) * 100) : 0;

        $kompensasi = Kompensasi::whereNotNull('kompensasi_disetujui')->sum('kompensasi_disetujui'); // pastikan field 'kompensasi' ada
        $targetKompensasi = 1000000;
        $persenKompensasi = $targetKompensasi > 0 ? min(100, ($kompensasi / $targetKompensasi) * 100) : 0;

        $days = collect(range(6, 0))->map(fn($i) => now()->subDays($i)->format('Y-m-d'));

        $chartData = $days->map(function ($date) {
            return [
                'tanggal' => Carbon::parse($date)->translatedFormat('d M'),
                'masuk' => KendaraanMasuk::whereDate('waktu_masuk', $date)->count(),
                'keluar' => KendaraanKeluar::whereDate('waktu_keluar', $date)->count(),
            ];
        });

        return view('home', compact(
            'total',
            'masukHariIni',
            'keluarHariIni',
            'rusak',
            'hilang',
            'jenis',
            'pendapatan',
            'persenPendapatan',
            'kompensasi',
            'persenKompensasi',
            'chartData',
            'stokParkir'
        ));
    }


}
