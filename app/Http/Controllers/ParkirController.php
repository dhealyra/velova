<?php

namespace App\Http\Controllers;

use App\Models\DataKendaraan;
use App\Models\KendaraanMasuk;
use App\Models\StokParkir;
use Illuminate\Http\Request;

class ParkirController extends Controller
{
    public function index(Request $request)
    {
        $query = KendaraanMasuk::with('kendaraan');

        // 🔍 Filter: Search No Polisi / Nama Pemilik / Status Pemilik
        if ($request->filled('search')) {
            $query->whereHas('kendaraan', function ($q) use ($request) {
                $q->where('no_polisi', 'like', '%' . $request->search . '%')
                ->orWhere('nama_pemilik', 'like', '%' . $request->search . '%')
                ->orWhere('status_pemilik', 'like', '%' . $request->search . '%');
            });
        }

        // 🔘 Filter: Status Parkir (masih parkir / sudah keluar)
        if ($request->filled('status_parkir')) {
            $query->where('status_parkir', $request->status_parkir);
        }

        // 🚘 Filter: Jenis Kendaraan dari relasi `kendaraan`
        if ($request->filled('jenis_kendaraan')) {
            $query->whereHas('kendaraan', function ($q) use ($request) {
                $q->where('jenis_kendaraan', $request->jenis_kendaraan);
            });
        }

        // 🗓️ Filter: Tanggal Masuk (created_at)
        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('created_at', [$request->tanggal_awal, $request->tanggal_akhir]);
        } elseif ($request->filled('tanggal_awal')) {
            $query->whereDate('created_at', '>=', $request->tanggal_awal);
        } elseif ($request->filled('tanggal_akhir')) {
            $query->whereDate('created_at', '<=', $request->tanggal_akhir);
        }

        // 📦 Paginate
        $parkir = $query->latest()->paginate(20);

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

    public function edit($id)
    {
        $parkir = KendaraanMasuk::with('kendaraan')->findOrFail($id);
        $kendaraans = DataKendaraan::all(); // Kalau mau pilih ulang kendaraan

        return view('petugas.parkir.edit', compact('parkir', 'kendaraans'));
    }

    public function update(Request $req, $id)
    {
        $req->validate([
            'plat_nomor' => 'required|string',
            'jenis_kendaraan' => 'required|in:mobil,motor,sepeda,lainnya',
        ]);

        $parkir = KendaraanMasuk::findOrFail($id);

        // Cek kendaraan (dari plat)
        $kendaraan = DataKendaraan::where('no_polisi', $req->plat_nomor)->first();

        // Kalau belum ada → buat kendaraan baru
        if (!$kendaraan) {
            $kendaraan = new DataKendaraan();
            $kendaraan->no_polisi = $req->plat_nomor;
            $kendaraan->jenis_kendaraan = $req->jenis_kendaraan;
            $kendaraan->status_pemilik = 'tamu';
            $kendaraan->nama_pemilik = null;
            $kendaraan->save();
        }

        // Cek kalau kendaraan baru sudah terparkir di entri lain
        $sudahParkir = KendaraanMasuk::where('id_kendaraan', $kendaraan->id)
            ->where('status_parkir', 0)
            ->where('id', '!=', $parkir->id)
            ->exists();

        if ($sudahParkir) {
            return redirect()->back()->with('error', 'Kendaraan ini sudah terparkir di entri lain!');
        }

        // Update ID kendaraan saja (waktu masuk tidak diubah)
        $parkir->id_kendaraan = $kendaraan->id;
        $parkir->save();

        // Redirect ke halaman tiket masuk ulang
        return redirect()->route('parkir.tiketMasuk', $parkir->id)->with('success', 'Data berhasil diperbarui & tiket baru telah dibuat!');
    }

    public function destroy($id)
    {
        $data = KendaraanMasuk::findOrFail($id);

        // Kalau masih terparkir, kembalikan slot
        if ($data->status_parkir == 0) {
            $kendaraan = $data->kendaraan;
            $statusPemilik = in_array($kendaraan->status_pemilik, ['staff', 'tamu']) ? $kendaraan->status_pemilik : 'tamu';

            $stok = StokParkir::where('jenis_kendaraan', $kendaraan->jenis_kendaraan)
                ->where('status_pemilik', $statusPemilik)
                ->first();

            if ($stok) {
                $stok->increment('sisa_slot');
            }
        }

        $data->delete();

        return redirect()->route('parkir.index')->with('success', 'Data kendaraan masuk berhasil dihapus.');
    }

}
