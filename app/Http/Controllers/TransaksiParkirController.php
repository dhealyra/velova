<?php

namespace App\Http\Controllers;

use App\Models\DataKendaraan;
use App\Models\KendaraanKeluar;
use App\Models\KendaraanMasuk;
use App\Models\Keuangan;
use App\Models\Kompensasi;
use App\Models\Pembayaran;
use App\Models\StokParkir;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <= Tambahin ini biar auth()->id() gak merah
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\DB;

class TransaksiParkirController extends Controller
{
    public function keluarIndex(Request $request)
    {
        $query = KendaraanKeluar::with('kendaraanMasuk.kendaraan');

        if ($request->filled('search')) {
            $query->whereHas('kendaraanMasuk.kendaraan', function ($q) use ($request) {
                $q->where('no_polisi', 'like', '%' . $request->search . '%')
                ->orWhere('nama_pemilik', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('jenis_kendaraan')) {
            $query->whereHas('kendaraanMasuk.kendaraan', function ($q) use ($request) {
                $q->where('jenis_kendaraan', $request->jenis_kendaraan);
            });
        }

        if ($request->filled('status_kondisi')) {
            $query->where('status_kondisi', $request->status_kondisi);
        }

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('waktu_keluar', [
                $request->tanggal_awal . ' 00:00:00',
                $request->tanggal_akhir . ' 23:59:59',
            ]);
        }

        $kendaraanKeluar = $query->latest()->paginate(10);

        return view('kendaraankeluar', compact('kendaraanKeluar'));
    }


    public function index(Request $request)
    {
        $query = Keuangan::with(['pembayaran.kendaraanMasuk.kendaraan', 'pembayaran.kendaraanKeluar']);

        if ($request->filled('search')) {
            $query->whereHas('pembayaran.kendaraanMasuk.kendaraan', function ($q) use ($request) {
                $q->where('no_polisi', 'like', '%' . $request->search . '%')
                ->orWhere('nama_pemilik', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('jenis_kendaraan')) {
            $query->whereHas('pembayaran.kendaraanMasuk.kendaraan', function ($q) use ($request) {
                $q->where('jenis_kendaraan', $request->jenis_kendaraan);
            });
        }

        if ($request->filled('status_kondisi')) {
            $query->whereHas('pembayaran.kendaraanKeluar', function ($q) use ($request) {
                $q->where('status_kondisi', $request->status_kondisi);
            });
        }

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('tanggal', [$request->tanggal_awal, $request->tanggal_akhir]);
        }

        $keuangan = $query->latest()->paginate(10);

        return view('transaksi', compact('keuangan'));
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

        $statusPemilik = $kendaraan->status_pemilik === 'tamu' ? 'tamu' : 'staff';

        $stokParkir = StokParkir::where('jenis_kendaraan', $kendaraan->jenis_kendaraan)
            ->where('status_pemilik', $statusPemilik)
            ->first();

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

        $parkir->status_parkir = 1;
        $parkir->save();

        $stokParkir->decrement('sisa_slot');

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
        $kendaraan = DataKendaraan::where('no_polisi', $masuk->plat_nomor)->first();

        $jamMasuk = Carbon::parse($masuk->waktu_masuk);
        $jamKeluar = Carbon::parse($kendaraanKeluar->waktu_keluar);
        $durasiJam = $jamMasuk->diffInHours($jamKeluar);
        $durasiJam = $durasiJam == 0 ? 1 : $durasiJam;

        $kompensasi = null;
        if ($req->has('idKompensasi')) {
            $kompensasi = Kompensasi::find($req->idKompensasi);
        }

        if ($kendaraan->status_pemilik === 'tamu') {
            switch ($kendaraan->jenis_kendaraan) {
                case 'mobil': $tarifPerJam = 5000; break;
                case 'motor': $tarifPerJam = 3000; break;
                case 'sepeda': $tarifPerJam = 0; break;
                default: $tarifPerJam = 4000;
            }
        } else {
            switch ($kendaraan->jenis_pemilik) {
                case 'dokter': $tarifPerJam = 0; break;
                case 'suster': $tarifPerJam = 1000; break;
                case 'staff': $tarifPerJam = 2000; break;
                default: $tarifPerJam = 2500;
            }
        }

        $tarif = $durasiJam * $tarifPerJam;

        if ($kompensasi && $kompensasi->status_pengajuan == 'disetujui') {
            $tarif = 0;
        }

        $denda = 0;
        if ($kendaraanKeluar->sebab_denda === 'tiket hilang') {
            $denda = 10000;
        }

        $total = $tarif + $denda;

        return view('petugas.transaksi.form', [
            'keluar' => $kendaraanKeluar,
            'masuk' => $masuk,
            'tarif' => $tarif,
            'denda' => $denda,
            'total' => $total,
            'kompensasi' => $kompensasi,
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
            'pembayaran' => 'required|in:tunai,gratis,qrish',
            'keterangan' => 'nullable|string'
        ]);

        // Ambil data kompensasi jika ada
        $kompensasi = Kompensasi::where('id_kendaraan_keluar', $req->id_kendaraan_keluar)
            ->where('status_pengajuan', 'disetujui')
            ->first();

        $nilaiKompensasi = $kompensasi ? $kompensasi->kompensasi_disetujui : 0;

        // Buat data pembayaran
        $pembayaran = Pembayaran::create([
            'id_kendaraan_masuk' => $req->id_kendaraan_masuk,
            'id_kendaraan_keluar' => $req->id_kendaraan_keluar,
            'id_kompensasi' => $kompensasi?->id,
            'tarif' => $req->tarif,
            'denda' => $req->denda,
            'kompensasi' => $nilaiKompensasi,
            'total' => $req->total,
            'pembayaran' => $req->pembayaran,
            'keterangan' => $req->keterangan,
            'user_id' => Auth::id(),
        ]);

        // Hitung selisih: jika negatif berarti rugi
        $selisih = ($req->tarif + $req->denda) - $nilaiKompensasi;

        if ($selisih < 0) {
            Keuangan::create([
                'tipe' => 'pengeluaran',
                'sumber' => 'kompensasi',
                'deskripsi' => 'Kompensasi melebihi tarif/denda',
                'jumlah' => abs($selisih),
                'tanggal' => now()->toDateString(),
                'total_keuangan' => 0,
                'user_id' => Auth::id(),
                'id_pembayaran' => $pembayaran->id,
            ]);
        } else {
            Keuangan::create([
                'tipe' => 'pendapatan',
                'sumber' => 'parkir',
                'deskripsi' => 'Pembayaran parkir dan denda',
                'jumlah' => $selisih,
                'tanggal' => now()->toDateString(),
                'total_keuangan' => 0,
                'user_id' => Auth::id(),
                'id_pembayaran' => $pembayaran->id,
            ]);
        }

        return redirect()->route('pembayaran.show', $pembayaran->id)->with('success', 'Pembayaran berhasil!');
    }

    public function show($id)
    {
        $data = Pembayaran::with([
            'kendaraanMasuk.kendaraan',
            'kendaraanKeluar',
            'user'
        ])->findOrFail($id);

        return view('petugas.transaksi.transaksi', compact('data'));
    }
}
