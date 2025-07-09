<?php

namespace App\Http\Controllers;

use App\Models\DataKendaraan;
use App\Models\KendaraanMasuk;
use Illuminate\Http\Request;

class ParkirController extends Controller
{
    public function index()
    {
        $parkir = KendaraanMasuk::with('kendaraan')->latest()->paginate(20);

        $tittle = 'Hapus Data';
        $text = "Apakah anda yakin?";
        confirmDelete($tittle, $text);

        return view('parkir', compact('parkir'));
    }

    public function create(Request $req)
    {
        $req->validate([
            'plat_nomor' => 'required',
            'jenis_kendaraan' => 'required',
        ]);

        // Cek plat / data kendaraan
        $kendaraan = DataKendaraan::where('no_polisi', $req->plat_nomor)->first();

        // add data kendaraan
        if (!$kendaraan) {
            $kendaraan = new DataKendaraan();
            $kendaraan->no_polisi = $req->no_polisi;
            $kendaraan->jenis_kendaraan = $req->jenis_kendaraan;
            $kendaraan->status_pemilik = 'tamu';
            $kendaraan->nama_pemilik = null;
            $kendaraan->save();
        }

        $sudahParkir = KendaraanMasuk::where('id_kendaraan', $kendaraan->id)
            ->where('status_parkir', 0)
            ->exists();

        if ($sudahParkir) {
            return redirect()->back()->with('error', 'Kendaraan ini masih terparkir!');
        }

        // Kalau belum terparkir, input ke tabel KendaraanMasuk
        $parkir = new KendaraanMasuk();
        $parkir->id_kendaraan = $kendaraan->id;
        $parkir->waktu_masuk = now();
        $parkir->status_parkir = 0; // 0 = masih terparkir
        $parkir->save();

        return redirect()->route('parkir.index')->with('success', 'Kendaraan berhasil masuk parkir!');
    }
    

}
