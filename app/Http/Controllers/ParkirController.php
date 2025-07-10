<?php

namespace App\Http\Controllers;

use App\Models\DataKendaraan;
use App\Models\KendaraanMasuk;
use App\Models\StokParkir;
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
            'plat_nomor' => 'required|string',
            'jenis_kendaraan' => 'required|in:motor,mobil,sepeda,lainnya',
        ]);

        $kendaraan = DataKendaraan::where('no_polisi', $req->plat_nomor)->first();

        // add data kendaraan
        if (!$kendaraan) {
            $kendaraan = new DataKendaraan();
            $kendaraan->no_polisi = $req->plat_nomor;
            $kendaraan->jenis_kendaraan = $req->jenis_kendaraan;
            $kendaraan->status_pemilik = 'tamu';
            $kendaraan->nama_pemilik = null;
            $kendaraan->save();
        }

        // Cek apakah kendaraan masih parkir
        $sudahParkir = KendaraanMasuk::where('id_kendaraan', $kendaraan->id)
            ->where('status_parkir', 0)
            ->exists();

        if ($sudahParkir) {
            return redirect()->back()->with('error', 'Kendaraan ini masih terparkir!');
        }

        $statusPemilik = in_array($kendaraan->status_pemilik, ['staff', 'tamu'])
            ? $kendaraan->status_pemilik
            : 'tamu';

        $stokParkir = StokParkir::where('jenis_kendaraan', $kendaraan->jenis_kendaraan)
            ->where('status_pemilik', $statusPemilik)
            ->first();

        if (!$stokParkir || $stokParkir->sisa_slot < 1) {
            return redirect()->back()->with('error', 'Stok parkir penuh atau tidak tersedia.');
        }

        // Buat data parkir baru
        $parkir = new KendaraanMasuk();
        $parkir->id_kendaraan = $kendaraan->id;
        $parkir->waktu_masuk = now();
        $parkir->status_parkir = 0;
        $parkir->save();

        $stokParkir->decrement('sisa_slot');

        return redirect()->route('parkir.tiketMasuk', $parkir->id)->with('success', 'Kendaraan berhasil masuk parkir!');
    }

    public function tiketMasuk($id)
    {
        $data = KendaraanMasuk::with('kendaraan')->findOrFail($id);

        return view('petugas.parkir.tiket', compact('data'));
    }

}
