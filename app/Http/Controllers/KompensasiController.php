<?php

namespace App\Http\Controllers;

use App\Models\KendaraanKeluar;
use App\Models\Kompensasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Auth;

class KompensasiController extends Controller
{

    public function index(Request $request)
    {
        $query = Kompensasi::with('kendaraanKeluar.kendaraanMasuk.kendaraan')->latest();

        if ($request->filled('status_pengajuan')) {
            $query->where('status_pengajuan', $request->status_pengajuan);
        }

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('created_at', [
                $request->tanggal_awal . ' 00:00:00',
                $request->tanggal_akhir . ' 23:59:59',
            ]);
        }

        $kompensasis = $query->paginate(10)->withQueryString();

        return view('kompensasi', compact('kompensasis'));
    }

    public function form($idKeluar)
    {
        $keluar = KendaraanKeluar::findOrFail($idKeluar);
        return view('petugas.kompensasi.form', compact('keluar'));
    }

    public function simpan(Request $req)
    {
        // validasi input
        $req->validate([
            'id_kendaraan_keluar'   => 'required|exists:kendaraan_keluars,id',
            'jenis_kompensasi'      => 'nullable|string',
            'kompensasi_disetujui'  => 'required|numeric|min:0',
            'nama_pemilik'          => 'required|string',
            'keterangan'            => 'nullable|string',
            'bukti'                 => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imageName = null;
        if ($req->hasFile('bukti')) {
            $image      = $req->file('bukti');
            $imageName  = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('image/bukti'), $imageName);
        }

        // simpan data
        Kompensasi::create([
            'id_kendaraan_keluar'  => $req->id_kendaraan_keluar,
            'bukti'                => $imageName,
            'jenis_kompensasi'     => $req->jenis_kompensasi,
            'tipe_kompensasi'      => 0,                  // internal by default
            'kompensasi_disetujui' => $req->kompensasi_disetujui,
            'nama_pemilik'         => $req->nama_pemilik,
            'keterangan'           => $req->keterangan,
            'status_pengajuan'     => 'pending',
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('kompensasi.index')->with('success', 'Pengajuan kompensasi terkirim!');
    }

    public function edit($id)
    {
        // Form edit kompensasi
        $kompensasi = Kompensasi::findOrFail($id);
        return view('petugas.kompensasi.edit', compact('kompensasi'));
    }

    public function update(Request $req, $id)
    {
        // validasi
        $req->validate([
            'jenis_kompensasi'      => 'nullable|string',
            'kompensasi_disetujui'  => 'required|numeric|min:0',
            'nama_pemilik'          => 'required|string',
            'keterangan'            => 'nullable|string',
            'bukti'                 => 'nullable|mimes:jpg,jpeg,png|max:2048',
        ]);

        $kompensasi = Kompensasi::findOrFail($id);

        // handle upload baru (hapus gambar lama kalau ada)
        if ($req->hasFile('bukti')) {
            if ($kompensasi->bukti && file_exists(public_path('image/bukti/' . $kompensasi->bukti))) {
                unlink(public_path('image/bukti/' . $kompensasi->bukti));
            }
            $image      = $req->file('bukti');
            $imageName  = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('image/bukti'), $imageName);
            $kompensasi->bukti = $imageName;
        }

        // update field lain
        $kompensasi->jenis_kompensasi     = $req->jenis_kompensasi;
        $kompensasi->kompensasi_disetujui = $req->kompensasi_disetujui;
        $kompensasi->nama_pemilik         = $req->nama_pemilik;
        $kompensasi->keterangan           = $req->keterangan;
        $kompensasi->save();

        return redirect()->route('kompensasi.index')
            ->with('success', 'Kompensasi diperbarui.');
    }

    public function destroy($id)
    {
        // hapus data + gambar
        $kompensasi = Kompensasi::findOrFail($id);
        if ($kompensasi->bukti && file_exists(public_path('image/bukti/' . $kompensasi->bukti))) {
            unlink(public_path('image/bukti/' . $kompensasi->bukti));
        }
        $kompensasi->delete();

        return redirect()->route('kompensasi.index')
            ->with('success', 'Kompensasi dihapus.');
    }

    public function setujui($id)
    {
        $kompensasi = Kompensasi::findOrFail($id);
        $kompensasi->status_pengajuan = 'disetujui';
        $kompensasi->save();

        $keluar = $kompensasi->kendaraanKeluar;

        return redirect()->route('transaksi.buat', [
            'id' => $keluar->id,
            'idKompensasi' => $kompensasi->id,
        ])->with('success', 'Kompensasi disetujui! Silakan proses transaksi.');
    }

    public function tolak($id)
    {
        $kompensasi = Kompensasi::findOrFail($id);
        $kompensasi->status_pengajuan = 'ditolak';
        $kompensasi->save();

        $keluar = $kompensasi->kendaraanKeluar;

        return redirect()->route('transaksi.buat', [
            'id' => $keluar->id,
            'idKompensasi' => $kompensasi->id,
        ])->with('success', 'Kompensasi ditolak! Silakan proses transaksi.');
    }

}
