<?php

namespace App\Http\Controllers;

use App\Models\DataKendaraan;
use App\Models\KendaraanKeluar;
use App\Models\KendaraanMasuk;
use App\Models\Pembayaran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiParkirController extends Controller
{
    public function index()
    {
        $transaksi = Pembayaran::with(['kendaraanMasuk.kendaraan', 'kendaraanKeluar']) ->latest()
        ->paginate(5);
        return view('admin.transaksi.index', compact('transaksi'));
    }

    public function autocompletePlat(Request $request)
    {
        $term = $request->term;

        $data = DB::table('data_kendaraans')
            ->join('kendaraan_masuks', 'data_kendaraans.id', '=', 'kendaraan_masuks.id_kendaraan')
            ->where('kendaraan_masuks.status_parkir', 0)
            ->where('data_kendaraans.no_polisi', 'LIKE', '%' . $term . '%')
            ->pluck('data_kendaraans.no_polisi');

        return response()->json($data);
    }

    public function kendaraanKeluar(Request $req)
    {
        $req->validate([
            'plat_nomor' => 'required',
        ]);

        $kendaraan = DataKendaraan::where('no_polisi', $req->plat_nomor)->first();
        if (!$kendaraan) {
            return redirect()->back()->with('error', 'Kendaraan tidak ditemukan!');
        }

        $parkir = KendaraanMasuk::where('id_kendaraan', $kendaraan->id)
            ->where('status_parkir', 0)
            ->first();

        if (!$parkir) {
            return redirect()->back()->with('error', 'Kendaraan tidak sedang terparkir!');
        }

        $keluar = new KendaraanKeluar();
        $keluar->id_kendaraan_masuk = $parkir->id;
        $keluar->waktu_keluar = now();
        $keluar->status_kondisi = $req->has('kondisi')
        ? (is_array($req->kondisi) ? implode(',', $req->kondisi) : $req->kondisi)
        : 'baik';
        $keluar->sebab_denda = $req->has('sebab_denda')
        ? (is_array($req->sebab_denda) ? implode(',', $req->sebab_denda) : $req->sebab_denda)
        : null;

        $keluar->save();

        // update status parkir
        $parkir->status_parkir = 1;
        $parkir->save();

        if ($keluar->status_kondisi === 'baik') {
            return $this->buatTransaksi($keluar->id, $req);
        } else {
            return redirect()->back()->with('kompensasi_prompt', $keluar->id);
        }
    }

    public function buatTransaksi($idKeluar, Request $req)
    {
        $kendaraanKeluar = KendaraanKeluar::findOrFail($idKeluar);
        $masuk = KendaraanMasuk::findOrFail($kendaraanKeluar->id_kendaraan_masuk);

        $jamMasuk = Carbon::parse($masuk->waktu_masuk);
        $jamKeluar = Carbon::parse($kendaraanKeluar->waktu_keluar);
        $durasiJam = $jamMasuk->diffInHours($jamKeluar);
        $durasiJam = $durasiJam == 0 ? 1 : $durasiJam;

        $tarif = $durasiJam * 2000;

        $denda = 0;
        if ($kendaraanKeluar->sebab_denda === 'tiket hilang') {
            $denda = 10000;
        } elseif ($req->has('denda_manual')) {
            $req->validate([
                'denda_manual' => 'nullable|numeric|min:0'
            ]);
            $denda = $req->denda_manual ?? 0;
        }

        $total = $tarif + $denda;

        return view('petugas.transaksi.form', [
            'keluar' => $kendaraanKeluar,
            'masuk' => $masuk,
            'tarif' => $tarif,
            'denda' => $denda,
            'total' => $total,
        ]);
    }

    public function prosesTransaksi(Request $req)
    {
        $req->validate([
            'id_kendaraan_masuk' => 'required|exists:kendaraan_masuks,id',
            'id_kendaraan_keluar' => 'required|exists:kendaraan_keluars,id',
            'tarif' => 'required|numeric',
            'denda' => 'required|numeric',
            'total' => 'required|numeric',
            'pembayaran' => 'required|in:tunai,gratis,qrish' // list metode yg valid
        ]);

        $pembayaran = Pembayaran::create([
            'id_kendaraan_masuk' => $req->id_kendaraan_masuk,
            'id_kendaraan_keluar' => $req->id_kendaraan_keluar,
            'id_kompensasi' => null,
            'tarif' => $req->tarif,
            'denda' => $req->denda,
            'total' => $req->total,
            'pembayaran' => $req->pembayaran,
        ]);

        return redirect()->route('pembayaran.show', $pembayaran->id)->with('success', 'Pembayaran berhasil!');
    }

    public function show($id)
    {
        $data = Pembayaran::with([
            'kendaraanMasuk.kendaraan',
            'kendaraanKeluar'
        ])->findOrFail($id);

        return view('petugas.transaksi.transaksi', compact('data'));
    }

}
